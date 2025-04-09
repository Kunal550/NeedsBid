<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['trade_users'] = User::where('isActive','A')->where('user_type_id','!=','1')->count();
        
        $data['siteIcone'] = Setting::first();

        return view('admin.panel.index',$data);
    }

    

    public function profilesetup(Request $request)
    {
        switch (true) {
            case $request->isMethod('GET'):
                return view('admin.panel.profile.index');
                break;

            case $request->isMethod('POST'):
                if ($request->type == 'profile-update') {
                    $rules = [
                        'name' => 'required|max:225|min:1',
                        'email' => 'required|email',
                        'phone' => 'required',
                        'profile_image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg',
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $validator->errors()->add('err_type', $request->type);
                        $validator->errors()->add($request->type . '_err_rowid', base64_encode(Auth::user()->id));
                        return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                    } else {
                        $filename = 'noimg.png';
                        if ($request->hasFile('profile_image')) {
                            $upPath = 'uploads/admin/';
                            $file = $request->file('profile_image');
                            $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                            if (!file_exists(public_path($upPath))) {
                                mkdir(public_path($upPath), 0777, true);
                            }
                            $file->move(public_path($upPath), $filename);
                        } else {
                            $filename = @User::where([['id', '=', Auth::user()->id]])->first();
                            $filename = $filename == null ? 'noimg.png' : $filename->profile_image;
                        }
                        if (User::where('id', Auth::user()->id)->update([
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'profile_image' => $filename
                        ])) {
                            return redirect()->back()->withSuccess('User Information Updated.');
                        }
                        return redirect()->back()->withError('Something went wrong.');
                    }
                }
                if ($request->type == 'password-update') {
                    $rules = [
                        'old_password' => ['required', function ($attribute, $value, $fail) {
                            if (!Hash::check($value, Auth::user()->password)) {
                                return $fail(__('The current password is incorrect.'));
                            }
                        }],
                        'new_password' => 'required|min:6|required_with:confirm_password',
                        'confirm_password' => 'required|min:6|same:new_password',
                        'profile_image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg',
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $validator->errors()->add('err_type', $request->type);
                        $validator->errors()->add($request->type . '_err_rowid', base64_encode(Auth::user()->id));
                        return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                    } else {
                        if (User::where('id', Auth::user()->id)->update([
                            'password' => Hash::make($request->confirm_password),
                        ])) {
                            return redirect()->back()->withSuccess('User Password Updated.');
                        }
                        return redirect()->back()->withError('Something went wrong.');
                    }
                }
                break;

            default:
                abort(403, 'Unauthorized action.');
                break;
        }
    }
}
