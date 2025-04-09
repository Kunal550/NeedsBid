<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContentModel;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $data['contents'] = ContentModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.content.index', $data);
    }

    public function create(Request $request)
    {
        return view('admin.panel.content.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make(
            $inputs,
            [
                'is_below_brand' => 'required',
                'title' => 'required',
                'button_name' => 'required',
                'button_link' => 'required',
                'short_desc' => 'nullable|min:5',
                'description' => 'nullable|min:5'
            ]
        );
        if ($validator->fails()) {
            $message = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $filename = '';
            $content = new ContentModel;
            $content->is_below_brand = $request->is_below_brand;
            $content->title = $request->title;
            $content->button_name = $request->button_name;
            $content->button_link = $request->button_link;
            $content->short_desc = $request->short_desc;
            $content->description = $request->description;
            if ($request->hasFile('content_images')) {

                $upPath = 'uploads/content_images/';
                $file = $request->file('content_images');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);

                $content->content_images = $filename;
            }
            $content->save();
        }
        return redirect()->route('admin.content.list')->withSuccess('Content added Successfully!!');
    }

    public function editContent(Request $request, $id)
    {
        $id = base64_decode($id);
        $data['content'] = ContentModel::where('id', $id)->first();
        return view('admin.panel.content.edit', $data);
    }
    public function content_update(Request $request)
    {
        $filename = '';
        if ($request->hasFile('content_images')) {
            $upPath = 'uploads/content_images/';
            $file = $request->file('content_images');
            $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path($upPath))) {
                mkdir(public_path($upPath), 0777, true);
            }
            $file->move(public_path($upPath), $filename);
        }
        elseif($request->content_id) {
            $filename = ContentModel::where([['id', '=', $request->content_id]])->first()->content_images;
            $filename = $filename == null ? 'noimg.png' : $filename;
        }else{
            $filename ='';
        }
        ContentModel::where('id', $request->content_id)->update([
           
            'title'             => $request->title,
            'content_images'             =>  $filename,
            'button_name'             =>  $request->button_name,
            'button_link'             =>  $request->button_link,
            'is_below_brand'             =>  $request->is_below_brand,
            'short_desc'             => $request->short_desc,
            'description'             =>  $request->description
        ]);
        return redirect()->route('admin.content.list')->withSuccess('Content updated Successfully!!');
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
