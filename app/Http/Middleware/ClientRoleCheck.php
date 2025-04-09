<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientRoleCheck
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if(!empty($role)){
            if(($role == 'admin')||($role == 'contractor')){
                if ($user && (($role == 'admin' && $user->user_type_id == 1) || ($role == 'contractor' && $user->user_type_id == 3))){
                    return $next($request);
                }else{
                    return redirect()->route('/');
                }                
            }
            
        }
    }
}
