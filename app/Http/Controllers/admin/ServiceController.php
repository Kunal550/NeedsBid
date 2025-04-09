<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Sub_service;
use App\Models\ServiceImagesModel;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        $data['service'] = Service::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.service.index', @$data);
    }

    public function create(Request $request)
    {
        return view('admin.panel.service.create');
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:services,name',
            'content' => 'nullable|min:5',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg|max:5000'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $service = new Service;
            $service->name = $request->name;
            $service->slug = Str::slug($request->name);
            $service->content = $request->content;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = Carbon::now()->timestamp . '_' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/service');
                $image->move($destinationPath, $image_name);
                $service->image = $image_name;
            }
            $service->save();
            if ($service) {
                $images = [];
                if ($request->service_images) {
                    foreach ($request->service_images as $key => $image) {
                        $imageName = Carbon::now()->timestamp . '_' . $image->getClientOriginalName();
                        $image->move(public_path('uploads/service_images/'), $imageName);
                        $images[]['service_images'] = $imageName;
                    }
                }
                foreach ($images as $key => $image) {
                    ServiceImagesModel::create([
                        'service_id' => $service->id,
                        'service_images' => $image['service_images']
                    ]);
                }
            }
        }
        return redirect()->route('admin.service.service')->withSuccess('Service Category added Successfully!!');
    }
    

    public function editService(Request $request, $id)
    {

        $id = base64_decode($id);
        $data['service'] = Service::where('id', $id)->first();
        $data['service_images'] = ServiceImagesModel::select('id', 'service_images')->where([['service_id', $id], ['status', '=', 'A']])->get();
        return view('admin.panel.service.edit', $data);
    }
    public function ServiceUpdate(Request $request)
    {
        $rules = [
            'name' => 'required',
            'content' => 'nullable|min:5',
            'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg|max:5000',
            'service_images.*' => 'nullable|image|mimes:webp,png,jpeg,jpg|max:5000'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
        $filename = '';
        if ($request->hasFile('image')) {
            $upPath = 'uploads/service/';
            $file = $request->file('image');
            $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path($upPath))) {
                mkdir(public_path($upPath), 0777, true);
            }
            $file->move(public_path($upPath), $filename);
        } else {
            $filename = Service::where([['id', '=', $request->service_id]])->first()->image;
            $filename = $filename == null ? 'noimg.png' : $filename;
        }
        Service::where('id', $request->service_id)->update([
            'name'             =>   $request->name,
            'slug'             =>   Str::slug($request->name),
            'content'             =>   $request->content,
            'image'             =>   $filename
        ]);

        $images = [];
        if ($request->service_images) {
            foreach ($request->service_images as $key => $image) {
                $imageName = Carbon::now()->timestamp . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/service_images/'), $imageName);
                $images[]['service_images'] = $imageName;
            }
        }
        foreach ($images as $key => $image) {
            ServiceImagesModel::where('service_id', $request->service_id)->create([
                'service_id' => $request->service_id,
                'service_images' => $image['service_images']
            ]);
        }
    }
        return redirect()->route('admin.service.service')->withSuccess('Service updated Successfully!!');
    }
    public function deleteImage(Request $request)
    {
        $image = ServiceImagesModel::where('id', $request->id)->update([ 'status' => 'D']);
        
        return response()->json(['code' => 200, 'msg' => "Service Image deleted successfully!!", 'data' => $image]);
    }

    public function showMoreImages($rowid)
    {
        $rowid = $rowid != null ? base64_decode($rowid) : null;
        if ($rowid != null) {
            if ($datas = ServiceImagesModel::select('id', 'service_images')->where([['service_id', '=', $rowid], ['status', '=', 'A']])->get()) {
                $html = '';
                if (!$datas->isEmpty()) {
                    foreach ($datas as $image) {
                        $prodImg = asset('public/uploads/service_images/' . $image->service_images);
                        $html .= '<div class="col-md-2"> <img style="width:100%" src="' . $prodImg . '"/ >
                    <a href="javascript:void(0);" class="del-gallery-img" data-id="' . $image->id . '"; data-id="more-images"><i class="text-danger fas fa-trash"></i></a> </div>';
                    }
                } else {
                    $html .= "<p>No Image Available</p>";
                }
                return response()->json(['code' => 200, 'data' => $html]);
            }
            return response()->json(['code' => 500]);
        }
        return response()->json(['code' => 500]);
    }


    public function SubServices(Request $request)
    {
        $service = base64_decode($request->service);
        switch (true) {
            case $request->isMethod('GET'):
                $data['services'] = Service::where([['status', '!=', 'D']])->get();
                $data['sub_services'] = Sub_service::with('sub_service_to_service')->where([['status',  'A']])->latest()->paginate(10);
                return view('admin.panel.service.sub_services', @$data);
                break;

            case $request->isMethod('POST'):
                $rules = [
                    'sub_service_name' => 'required',
                    'service' => 'required',
                    'image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $validator->errors()->add('subservice_err', '1');
                    $validator->errors()->add('subservice_err_rowid', base64_encode(@$request->rowid));
                    return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                } else {
                    $filename = 'noimg.png';
                    if ($request->hasFile('image')) {
                        $upPath = 'uploads/sub_service/';
                        $file = $request->file('image');
                        $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                        if (!file_exists(public_path($upPath))) {
                            mkdir(public_path($upPath), 0777, true);
                        }
                        $file->move(public_path($upPath), $filename);
                    } elseif ($request->rowid) {
                        $filename = Sub_service::where([['id', '=', $request->rowid]])->first()->image;
                        $filename = $filename == null ? 'noimg.png' : $filename;
                    } else {
                        $filename = '';
                    }

                    if (!empty($request->rowid)) {
                        Sub_service::where('id', $request->rowid)
                            ->update([
                                'name' => $request->sub_service_name,
                                'slug' => Str::slug($request->sub_service_name),
                                'content' => $request->content,
                                'service_id' => $service,
                                'image' => $filename
                            ]);
                        return redirect()->back()->withSuccess('Sub Service Updated successfully.');
                    } else {
                        Sub_service::insert([
                            'name' => $request->sub_service_name,
                            'slug' => Str::slug($request->sub_service_name),
                            'content' => $request->content,
                            'service_id' => $service,
                            'image' => $filename
                        ]);
                        return redirect()->back()->withSuccess('Sub Service Added successfully.');
                    }
                    return redirect()->back()->withError('Soemthing went wrong.');
                }
                break;

            default:
                abort(403, 'Unauthorized action.');
                break;
        }
    }
    public function getsinglerow($rowid)
    {
        $rowid = $rowid != null ? base64_decode($rowid) : null;
        if ($rowid != null) {
            if ($data = Service::where([['id', '=', $rowid]])->first()) {
                return response()->json(['code' => 200, 'data' => $data]);
            }
            return response()->json(['code' => 500]);
        }
        return response()->json(['code' => 500]);
    }

    public function EditSubService($rowid)
    {
        $rowid = $rowid != null ? base64_decode($rowid) : null;
        if ($rowid != null) {
            if ($data = Sub_service::with('sub_service_to_service')->where([['id', '=', $rowid]])->first()) {
                return response()->json(['code' => 200, 'data' => $data]);
            }
            return response()->json(['code' => 500]);
        }
        return response()->json(['code' => 500]);
    }
}
