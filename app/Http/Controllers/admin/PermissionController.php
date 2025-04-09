<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $data = Permission::orderBy('id', 'DESC')->get();
        return view('admin.panel.permission.index', compact('data'));
    }

    public function create()
    {
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
        $data = Permission::where('id', decrypt($id))->first();
        

        return view('admin.panel.permission.edit', compact('data'));
    }

    public function destroy($id)
    {
        Permission::where('id', decrypt($id))->delete();
        return redirect()->route('admin.permissions.list')->with('error', 'Permission deleted successfully.');
    }
}
