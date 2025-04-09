<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
{


    public function index(Request $request)
    {
        $data['customers'] = User::where([['status', '!=', 'D'], ['user_type_id', '!=', 1]])->latest()->paginate(10);
        $data['roles'] = Role::all();
        return view('admin.panel.user.index', $data);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.panel.user.create', compact('roles'));
    }

    

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:projects,title',
            'email' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $roles = array_map('base64_decode', $request->roles);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->new_password)
            ]);
            $user->syncRoles($roles);

            return redirect()->route('admin.users.list')->withSuccess('User Added successfully.');
        }
    }

    public function editUser($id)
    {

        $id = base64_decode($id);
        $roles = Role::all();
        $user = User::with('roles')->where([['id', '=', $id]])->first();

        return view('admin.panel.user.edit', compact('roles', 'user'));
    }

    public function updateUser(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $user = User::find(base64_decode($request->user_id));
            $roles = $request->roles;
            $user->update([
                'name' => $request->name,
                'email' => $request->email,

            ]);
            $user->syncRoles($roles);
            return redirect()->back()->withSuccess('User Updated successfully.');
        }
        return redirect()->back()->withSuccess('Project Updated Successfully!!');
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
