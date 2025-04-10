<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            Gate::authorize('permission');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $data = Permission::orderBy('id', 'DESC')->latest()->paginate(10);
        return view('admin.panel.permission.index', compact('data'));
    }

    public function create()
    {
        try {
            Gate::authorize('permission-create');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        return view('admin.panel.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions|max:255',
        ]);
        Permission::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
            ]
        );
        if ($request->id) {
            $msg = 'Permission updated successfully.';
        } else {
            $msg = 'Permission created successfully.';
        }
        return redirect()->route('admin.permissions.list')->with('success', $msg);
    }

    public function edit($id)
    {
        try {
            Gate::authorize('permission-edit');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $data = Permission::where('id', decrypt($id))->first();

        return view('admin.panel.permission.edit', compact('data'));
    }

    public function destroy(Request $request)
    {
        try {
            Gate::authorize('permission-delete');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

        if ($request->tbl != '') {
            $rowid = ($request->rowid != null) ? base64_decode($request->rowid) : null;
            if ($rowid != null) :
                if ($upadte = DB::table($request->tbl)->where([['id', '=', $rowid]])) {
                    Permission::where('id', $rowid)->delete();
                    return response()->json(['code' => 200, 'msg' => 'Deleted Successfully!!', 'data' => $upadte]);
                }
                return response()->json(['code' => 500, 'msg' => 'Something went wrong.', 'data' => '']);
            endif;
        }
        return response()->json(['code' => 500, 'msg' => 'Table value required.', 'data' => '']);

        // Permission::where('id', decrypt($id))->delete();
        // return redirect()->route('admin.permissions.list')->with('error', 'Permission deleted successfully.');
    }
}
