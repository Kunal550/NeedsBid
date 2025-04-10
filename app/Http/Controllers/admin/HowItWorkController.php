<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HowItWorkModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class HowItWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Gate::authorize('how_it_work');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

        $data['how_it_works'] = HowItWorkModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.how_it_work.index', @$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Gate::authorize('how_it_work-create');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        return view('admin.panel.how_it_work.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'how_it_work' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {

            $filename = 'noimg.png';
            if ($request->hasFile('how_it_work_image')) {
                $upPath = 'uploads/how_it_work/';
                $file = $request->file('how_it_work_image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->rowid) {
                $filename = HowItWorkModel::where([['id', '=', $request->rowid]])->first()->how_it_work_image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }

            HowItWorkModel::insert([
                'name' => $request->how_it_work,
                'slug' => Str::slug($request->how_it_work),
                'how_it_work_image' => $filename,
                'description' => $request->desc,
                'created_at'     => date('Y-m-d H:i:s')

            ]);

            return redirect()->route('admin.cms.how_it_work.list')->withSuccess('How It Work Added successfully.');
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
            Gate::authorize('how_it_work-edit');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

        $id = base64_decode($id);
        $data = HowItWorkModel::where([['id', '=', $id]])->first();
        return view('admin.panel.how_it_work.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $rules = [
            'how_it_work' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $filename = 'noimg.png';
            if ($request->hasFile('how_it_work_image')) {
                $upPath = 'uploads/how_it_work/';
                $file = $request->file('how_it_work_image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->work_id) {
                $filename = HowItWorkModel::where([['id', '=', base64_decode($request->work_id)]])->first()->how_it_work_image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }
            $work = HowItWorkModel::find(base64_decode($request->work_id));
            $work->update([
                'name' => $request->how_it_work,
                'slug' => Str::slug($request->how_it_work),
                'how_it_work_image' => $filename,
                'description' => $request->page_desc,
                'created_at'     => date('Y-m-d H:i:s')

            ]);
            return redirect()->route('admin.cms.how_it_work.list')->withSuccess('How It Work Updated successfully.');
        }
        return redirect()->back()->withSuccess('Page Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            Gate::authorize('how_it_work-delete');
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
