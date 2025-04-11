<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\ConstructionTypeModel;
use App\Models\ContactorModel;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\StatesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class ProjectController extends Controller
{
    public function index()
    {
        return view('site.project.index');
    }

    public function create()
    {
        $data['project_categories'] = ProjectCategory::where([['status', '!=', 'D']])->get();
        $data['contractors'] = ContactorModel::where([['status', '!=', 'D']])->get();
        $data['constructors'] = ConstructionTypeModel::where([['status', '!=', 'D']])->get();
        $data['states'] = StatesModel::where([['status', '!=', 'D']])->get();
        $data['project_categories'] = ProjectCategory::where([['status', '!=', 'D']])->get();
        return view('site.project.create',@$data);
    }

    public function store(Request $request)
    {
        // dd('ddd',$request->all());
        $rules = [
            'name' => 'required|unique:projects,title',
            'project_category_name' => 'required',
            'price' => 'required',
            'project_deadline' => 'required',
            'content' => 'nullable|min:5',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg|max:5000',
            'other_file' => 'nullable|mimes:pdf,doc,png,jpeg,gif,jpg,docx|max:5000'

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
            $project->client_id = Auth::user()->id;


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

        return redirect()->route('project.list')->withSuccess('Project Added Successfully!!');
        return view('site.project.create');
    }
}
