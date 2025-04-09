<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectCateoryController extends Controller
{
    public function index(Request $request)
    {
        $data['project_categories'] = ProjectCategory::where([['status', 'A']])->latest()->paginate(10);
        return view('admin.panel.project_category.index', @$data);
    }

    public function create()
    {
        return view('admin.panel.project_category.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:project_categories,name'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $project_cat = new ProjectCategory();
            $project_cat->name = $request->name;
            $project_cat->slug = Str::slug($request->name);
            $project_cat->content = $request->content;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = Carbon::now()->timestamp . '_' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/project_category');
                $image->move($destinationPath, $image_name);
                $project_cat->image = $image_name;
            }

            $project_cat->save();
        }

        return redirect()->route('admin.project-category.list')->withSuccess('Project Category Added Successfully!!');
    }

    public function editcategory($id)
    {

        $id = base64_decode($id);

        $category = ProjectCategory::where([['id', '=', $id]])->first();

        return view('admin.panel.project_category.edit', compact('category'));
    }

    public function updatecategory(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $filename = '';

            if ($request->hasFile('image')) {
                $upPath = 'uploads/project_category/';
                $file = $request->file('image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } else {
                $filename = ProjectCategory::where([['id', '=', base64_decode($request->cat_id)]])->first()->image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            }

            ProjectCategory::where('id', base64_decode($request->cat_id))->update([
                'name'             =>   $request->name,
                'slug'             =>   Str::slug($request->name),
                'content'             =>   $request->content,
                'image'             =>   $filename,
            ]);
            return redirect()->route('admin.project-category.list')->withSuccess('Project Category Updated successfully.');
        }
        return redirect()->back()->withSuccess('Project Category Updated Successfully!!');
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
