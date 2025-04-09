<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FaqModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['faq_details'] = FaqModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.faq.index', @$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.panel.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'question' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            FaqModel::insert([
                'question' => $request->question,
                'slug' => Str::slug($request->question),
                'answer' => $request->answer,
                'created_at'     => date('Y-m-d H:i:s')
            ]);

            return redirect()->route('admin.cms.faq.list')->withSuccess('FAQ Added successfully.');
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
        $data = FaqModel::where([['id', '=', $id]])->first();
        return view('admin.panel.faq.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $rules = [
            'question' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
         
            $faq = FaqModel::find(base64_decode($request->faq_id));
            $faq->update([
                'question' => $request->question,
                'slug' => Str::slug($request->question),
                'answer' => $request->answer,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('admin.cms.faq.list')->withSuccess('FAQ Updated successfully.');
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
