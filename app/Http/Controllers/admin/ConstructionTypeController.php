<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConstructionTypeModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ConstructionTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['constructors'] = ConstructionTypeModel::where([['status', '!=', 'D']])->latest()->paginate(10);
        return view('admin.panel.constructor.index', @$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.panel.constructor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            ConstructionTypeModel::insert([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]);
            return redirect()->route('admin.constructor-type.list')->withSuccess('Contractor Added successfully.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $id = base64_decode($id);
        $data = ConstructionTypeModel::where([['id', '=', $id]])->first();
        return view('admin.panel.constructor.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required'

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {

            $constructor = ConstructionTypeModel::find(base64_decode($request->constructor_id));
            $constructor->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('admin.constructor-type.list')->withSuccess('Contractor Updated successfully.');
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
