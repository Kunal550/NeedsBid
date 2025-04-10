<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BlogModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Gate::authorize('blog');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $data['blogs'] = BlogModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.blog.index', @$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Gate::authorize('blog-create');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        return view('admin.panel.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'blog_name' => 'required',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {

            $filename = 'noimg.png';
            if ($request->hasFile('image')) {
                $upPath = 'uploads/blog/';
                $file = $request->file('image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->rowid) {
                $filename = BlogModel::where([['id', '=', $request->rowid]])->first()->blog_images;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }

            BlogModel::insert([
                'name' => $request->blog_name,
                'slug' => Str::slug($request->blog_name),
                'description' => $request->blog_description,
                'blog_images' => $filename,
                'created_at'     => date('Y-m-d H:i:s')
            ]);

            return redirect()->route('admin.cms.blog.list')->withSuccess('Blog Added successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            Gate::authorize('blog-edit');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

        $id = base64_decode($id);
        $data = BlogModel::where([['id', '=', $id]])->first();
        return view('admin.panel.blog.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $rules = [
            'blog_name' => 'required',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $filename = 'noimg.png';
            if ($request->hasFile('image')) {
                $upPath = 'uploads/blog/';
                $file = $request->file('image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->rowid) {
                $filename = BlogModel::where([['id', '=', $request->rowid]])->first()->blog_images;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }
            $blog = BlogModel::find(base64_decode($request->blog_id));
            $blog->update([
                'name' => $request->blog_name,
                'slug' => Str::slug($request->blog_name),
                'description' => $request->blog_description,
                'blog_images' => $filename,
                'created_at'     => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('admin.cms.blog.list')->withSuccess('Blog Updated successfully.');
        }
        return redirect()->back()->withSuccess('Page Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            Gate::authorize('blog-delete');
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
