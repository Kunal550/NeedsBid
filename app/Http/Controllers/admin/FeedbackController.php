<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerFeedbackModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $data['customerFeedback'] = CustomerFeedbackModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.feedback.index', @$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.panel.feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'designation' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {

            $filename = 'noimg.png';
            if ($request->hasFile('client_image')) {
                $upPath = 'uploads/client_images/';
                $file = $request->file('client_image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->rowid) {
                $filename = CustomerFeedbackModel::where([['id', '=', $request->rowid]])->first()->client_image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }

            CustomerFeedbackModel::insert([
                'name' => $request->name,
                'designation' => $request->designation,
                'content' => $request->client_desc,
                'client_image' => $filename,
                'created_at'     => date('Y-m-d H:i:s')
            ]);

            return redirect()->route('admin.cms.feedback.list')->withSuccess('Feedback Added successfully.');
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

        $id = base64_decode($id);
        $data = CustomerFeedbackModel::where([['id', '=', $id]])->first();
        return view('admin.panel.feedback.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required',
            'designation' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $filename = 'noimg.png';
            if ($request->hasFile('client_image')) {
                $upPath = 'uploads/client_images/';
                $file = $request->file('client_image');
                $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $filename);
            } elseif ($request->feedback_id) {
                $filename = CustomerFeedbackModel::where([['id', '=', base64_decode($request->feedback_id)]])->first()->client_image;
                $filename = $filename == null ? 'noimg.png' : $filename;
            } else {
                $filename = '';
            }
            $feedback = CustomerFeedbackModel::find(base64_decode($request->feedback_id));
            $feedback->update([
                'name' => $request->name,
                'designation' => $request->designation,
                'content' => $request->client_desc,
                'client_image' => $filename,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('admin.cms.feedback.list')->withSuccess('Feedback Updated successfully.');
        }
        return redirect()->back()->withSuccess('Page Updated Successfully!!');
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
