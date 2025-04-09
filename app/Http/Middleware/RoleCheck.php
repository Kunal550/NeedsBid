<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class RoleCheck
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        if(!empty($role)){
            if(($role == 'user')){
                if(!empty($user) && ($user->user_type_id == '0')){
                    return $next($request);
                }else{
                    return redirect()->route('/');
                }                
            }
            if(($role == 'admin')){
                if(!empty($user) && ($user->user_type_id == '1')){
                    return $next($request);
                }else{
                    return redirect()->route('admin.logout');
                }
            }
        }
    }
}
