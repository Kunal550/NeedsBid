<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TestimonialModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TestiMonialWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['testimonials'] = TestimonialModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.testimonial.index', @$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.panel.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'testimonial_name' => 'required',
            'rating' => 'required|numeric|min:0|max:5'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {

            $filename = 'noimg.png';
            if ($request->hasFile('testimonial_image')) {
                $upPath = 'uploads/testimonial_image/';
                $file = $request->file('testimonial_image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->rowid) {
                $filename = TestimonialModel::where([['id', '=', $request->rowid]])->first()->testimonial_image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }

            TestimonialModel::insert([
                'name' => $request->testimonial_name,
                'slug' => Str::slug($request->testimonial_name),
                'description' => $request->testimonial_desc,
                'designation' => $request->designation,
                'rating' => $request->rating,
                'testimonial_image' => $filename,
                'created_at'     => date('Y-m-d H:i:s')
            ]);

            return redirect()->route('admin.cms.testimonial.list')->withSuccess('Testimonial Added successfully');
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
    public function edit($id)
    {
        $id = base64_decode($id);
        $data = TestimonialModel::where([['id', '=', $id]])->first();
        return view('admin.panel.testimonial.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $rules = [
            'testimonial_name' => 'required',
            'rating' => 'required|numeric|min:0|max:5'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {

            $filename = 'noimg.png';
            if ($request->hasFile('testimonial_image')) {
                $upPath = 'uploads/testimonial_image/';
                $file = $request->file('testimonial_image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->rowid) {
                $filename = TestimonialModel::where([['id', '=', $request->rowid]])->first()->testimonial_image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }

            TestimonialModel::where('id',base64_decode($request->test_id))
                ->update([
                    'name' => $request->testimonial_name,
                    'slug' => Str::slug($request->testimonial_name),
                    'description' => $request->testimonial_desc,
                    'designation' => $request->designation,
                    'rating' => $request->rating,
                    'testimonial_image' => $filename,
                    'updated_at'     => date('Y-m-d H:i:s')
                ]);

            return redirect()->route('admin.cms.testimonial.list')->withSuccess('Testimonial Added successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
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
