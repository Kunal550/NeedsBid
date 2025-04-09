<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ConstructionTypeModel;
use App\Models\ContactorModel;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\StatesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        $data['projects'] = Project::with('project_to_project_category')->where([['status', '!=', 'D']])->latest()->paginate(10);
        $data['project_categories'] = ProjectCategory::where([['status', '!=', 'D']])->get();
        return view('admin.panel.projects.index', @$data);
    }

    public function create(Request $request)
    {
        $data['project_categories'] = ProjectCategory::where([['status', '!=', 'D']])->get();
        $data['contractors'] = ContactorModel::where([['status', '!=', 'D']])->get();
        $data['constructors'] = ConstructionTypeModel::where([['status', '!=', 'D']])->get();
        $data['states'] = StatesModel::where([['status', '!=', 'D']])->get();

        $data['project_categories'] = ProjectCategory::where([['status', '!=', 'D']])->get();
        return view('admin.panel.projects.create', @$data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:projects,title',
            'project_category_name' => 'required',
            'price' => 'required',
            'project_deadline' => 'required',
            'content' => 'nullable|min:5',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg|max:5000',
            'other_file' => 'nullable|mimes:pdf,doc,docx|max:5000'
            
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $project = new Project();
            $project->title = $request->name;
            $project->slug = Str::slug($request->name);

            $project->category_id = base64_decode($request->project_category_name);
            $project->budget = $request->price;
            $project->description = $request->content;
            $project->bid_deadline = $request->project_deadline;
            $project->contractor_trade = base64_decode($request->contractor_trade);
            $project->constructor_type = base64_decode($request->constructor_type);
            $project->state_id = base64_decode($request->states);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = Carbon::now()->timestamp . '_' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/projects');
                $image->move($destinationPath, $image_name);
                $project->image = $image_name;
            }

            if ($request->hasFile('other_file')) {
                $other = $request->file('other_file');
                $other_file_name = Carbon::now()->timestamp . '_' . $other->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/projects/other_files');
                $other->move($destinationPath, $other_file_name);
                $project->other_file = $other_file_name;
            }
            $project->save();
        }

        return redirect()->route('admin.projects.project')->withSuccess('Project Added Successfully!!');
    }

    public function edit(Request $request, $id)
    {
        $id = base64_decode($id);
        $data['project'] = Project::where('id', $id)->first();
        $data['project_categories'] = ProjectCategory::where([['status', '!=', 'D']])->get();
        $data['contractors'] = ContactorModel::where([['status', '!=', 'D']])->get();
        $data['constructors'] = ConstructionTypeModel::where([['status', '!=', 'D']])->get();
        $data['states'] = StatesModel::where([['status', '!=', 'D']])->get();
        return view('admin.panel.projects.edit', $data);
    }


    public function ProjectUpdate(Request $request)
    {

        $rules = [
            'name' => 'required',
            'project_category_name' => 'required',
            'price' => 'required',
            'project_deadline' => 'required',
            'content' => 'nullable|min:5',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg|max:5000',
            'other_file' => 'nullable|mimes:pdf,doc,docx|max:5000'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $filename = '';
            $other_filename = '';

            if ($request->hasFile('image')) {
                $upPath = 'uploads/projects/';
                $file = $request->file('image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } else {
                $filename = Project::where([['id', '=', $request->project_id]])->first()->image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            }


            if ($request->hasFile('other_file')) {
                $upPath = 'uploads/projects/other_files';
                $file = $request->file('other_file');
                $other_filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $other_filename);
            } else {
                $other_filename = Project::where([['id', '=', $request->project_id]])->first()->other_file;
                $other_filename = $other_filename == null ? 'noimg.png' : $other_filename;
            }
            Project::where('id', $request->project_id)->update([
                'title'             =>   $request->name,
                'slug'             =>   Str::slug($request->name),
                'category_id'             =>   base64_decode($request->project_category_name),
                'budget'             =>   $request->price,
                'contractor_trade'             =>   base64_decode($request->contractor_trade),
                'constructor_type'             =>    base64_decode($request->constructor_type),
                'state_id'             =>   base64_decode($request->states),
                'description'             =>   $request->content,
                'bid_deadline'             =>   $request->project_deadline,
                'image'             =>   $filename,
                'other_file'             =>   $other_filename
            ]);
        }
        return redirect()->back()->withSuccess('Project Updated Successfully!!');
    }

    public function delete(Request $request)
    {
        if ($request->tbl != '') {
            $rowid = ($request->rowid != null) ? base64_decode($request->rowid) : null;
            if ($rowid != null) :
                if ($upadte = DB::table($request->tbl)->where([['id', '=', $rowid]])->update(['status' => $request->status])) {
                    $request->status == 'D';
                    return response()->json(['code' => 200, 'msg' => 'Deleted Successfully!!', 'data' => $upadte]);
                }
                return response()->json(['code' => 500, 'msg' => 'Something went wrong.', 'data' => '']);
            endif;
        }
        return response()->json(['code' => 500, 'msg' => 'Table value required.', 'data' => '']);
    }

   
}
