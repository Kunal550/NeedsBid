<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends Controller
{

   
    public function index(Request $request)
    {
        $data['banner'] = Banner::where([['status', '!=', 'D']])->orderBy('id', 'desc')->paginate(10);
        return view('admin.panel.banner.index', @$data);
    }

    public function create(Request $request)
    {
        
        return view('admin.panel.banner.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg|max:5000'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $banner = new Banner;
            $banner->title = $request->name;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = Carbon::now()->timestamp . '_' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/banner');
                $image->move($destinationPath, $image_name);
                $banner->image = $image_name;
            }
            $banner->save();
        }
        return redirect()->route('admin.banner.banner')->withSuccess('Banner added Successfully!!');
    }

    public function editBanner(Request $request, $id)
    {
        $id = base64_decode($id);
        $data['banner'] = Banner::where('id', $id)->first();
        return view('admin.panel.banner.edit', $data);
    }
    public function BannerUpdate(Request $request)
    {
        $filename = '';
        if ($request->hasFile('image')) {
            $upPath = 'uploads/banner/';
            $file = $request->file('image');
            $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path($upPath))) {
                mkdir(public_path($upPath), 0777, true);
            }
            $file->move(public_path($upPath), $filename);
        } elseif ($request->banner_id) {
            $filename = Banner::where([['id', '=', $request->banner_id]])->first()->image;
            $filename = $filename == null ? 'noimg.png' : $filename;
        } else {
            $filename = '';
        }

        Banner::where('id', $request->banner_id)->update([
            'title'             =>   $request->name,
            'image'             =>   $filename
        ]);


        return redirect()->route('admin.banner.banner')->withSuccess('Banner updated Successfully!!');
    }

    public function deletebanner(Request $request)
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
