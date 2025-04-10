<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
class PageController extends Controller
{
    public function index(Request $request)
    {
        try {
            Gate::authorize('page');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $data['pages'] = PageModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.page.index', @$data);
    }

    public function create()
    {
        try {
            Gate::authorize('page-create');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        
        return view('admin.panel.page.create');
    }



    public function store(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            
            PageModel::create([
                'name' => $request->name,
                'slug'             =>   Str::slug($request->name),
                'description'             =>   $request->page_desc,
            ]);

            return redirect()->route('admin.cms.pages.list')->withSuccess('Page Added successfully.');
        }
    }

    public function edit($id)
    {
        try {
            Gate::authorize('page-edit');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

        $id = base64_decode($id);
        $page = PageModel::where([['id', '=', $id]])->first();
        return view('admin.panel.page.edit', compact('page'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $rules = [
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $user = PageModel::find(base64_decode($request->page_id));
            $user->update([
                'name' => $request->name,
                'slug'             =>   Str::slug($request->name),
                'description'             =>   $request->page_desc

            ]);
            return redirect()->route('admin.cms.pages.list')->withSuccess('Page Updated successfully.');
        }
        return redirect()->back()->withSuccess('Page Updated Successfully!!');
    }

    public function delete(Request $request)
    {
        try {
            Gate::authorize('page-delete');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

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
