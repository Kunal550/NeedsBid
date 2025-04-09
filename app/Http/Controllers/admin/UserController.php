<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        $data['users'] = User::where([['isActive', '!=', 'D'], ['user_type_id', '!=', 1]])->latest()->paginate(10);
        $data['roles'] = Role::all();
        return view('admin.panel.user.index', $data);

    }

    public function create(){
        
    }

    public function store(){
        
    }

    public function edit(){
        
    }
    public function update(){
        
    }
    public function delete(){
        
    }
}
