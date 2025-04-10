<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\AboutModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
class AboutController extends Controller
{
    public function index(Request $request)
    {
        try {
            Gate::authorize('about');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $data['pages'] = AboutModel::with('about_to_pages')->where([['status', '!=', 'D']])->orderBy('id', 'desc')->paginate(10);
        return view('admin.panel.about.index', @$data);
    }
    public function create(Request $request)
    {
        try {
            Gate::authorize('about-create');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        return view('admin.panel.about.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'parent_id' => 'required',
            'content' => 'nullable|min:5',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $about = new AboutModel;
            $about->name = $request->name;
            $about->slug = Str::slug($request->name);
            $about->parent_id = $request->parent_id;
            $about->description = $request->content;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = Carbon::now()->timestamp . '_' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/about');
                $image->move($destinationPath, $image_name);
                $about->image = $image_name;
            }
            $about->save();
        }
        return redirect()->route('admin.about.list')->withSuccess('Pages added Successfully!!');
    }
    public function editAbout(Request $request, $id)
    {
        try {
            Gate::authorize('about-edit');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

        $id = base64_decode($id);
        $data['pages'] = AboutModel::with('about_to_pages')->where('id', $id)->first();
        return view('admin.panel.about.edit', $data);
    }
    public function about_update(Request $request)
    {
        $filename = '';
        if ($request->hasFile('image')) {
            $upPath = 'uploads/about/';
            $file = $request->file('image');
            $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path($upPath))) {
                mkdir(public_path($upPath), 0777, true);
            }
            $file->move(public_path($upPath), $filename);
        } else {
            $filename = AboutModel::where([['id', '=', $request->pages_id]])->first()->image;
            $filename = $filename == null ? 'noimg.png' : $filename;
        }
        AboutModel::where('id', $request->pages_id)->update([
            'name'             =>   $request->name,
            'slug'             => Str::slug($request->name),
            'parent_id'             =>   base64_decode($request->parent_id),
            'description'             =>   $request->content,
            'image'             =>   $filename
        ]);
        return redirect()->route('admin.about.list')->withSuccess('Pages updated Successfully!!');
    }
}
