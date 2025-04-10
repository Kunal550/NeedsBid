<?php


namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
class RoleController extends Controller
{

    public function index()
    {
        try {
            Gate::authorize('role');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $data = Role::orderBy('id','DESC')->get();
        return view('admin.panel.role.index', compact('data'));
    }

    public function create()
    {
        try {
            Gate::authorize('role-create');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $permissions = Permission::select('id', 'name')->get();
        
        //Log::info('User {id} failed to login.', [$permissions] );

        return view('admin.panel.role.create', compact( 'permissions' ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
           
        ]);
        
        $role = Role::updateOrCreate(
            [
                'id'=>$request->id
            ],[
                'name'=>$request->name,
            ]
        );

        $role->permissions()->sync($request->input('permission', []));

        if($request->id)
        {
            $msg = 'Role updated successfully.';
        }
        else
        {
            $msg = 'Role created successfully.';
        }
        return redirect()->route('admin.roles.list')->with('success',$msg);
    }

    public function edit($id)
    {
        try {
            Gate::authorize('role-edit');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $data = Role::where('id',decrypt($id))->first();
        return view('admin.panel.role.edit',compact('data'));
    }

    public function destroy($id)
    {
        try {
            Gate::authorize('role-delete');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        Role::where('id',decrypt($id))->delete();
        return redirect()->route('admin.roles.list')->with('error','Role deleted successfully.');
    }

    
}
