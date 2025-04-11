<?php

namespace App\Http\Controllers\site;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Mail\GeneralMail;
use App\Mail\RegisterMail;
use App\Mail\NewRegisterMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('site.auth.login');
    }

    public function Userlogin(Request $request)
    {
        
        $rules = [
            'email' => 'required',
            'password' => 'required'

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        } else {
            $remember = ($request->rememberme == 'on') ? true : false;
            if (Auth::validate(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'user_type_id' => 0, 'status' => 'A'], $remember)) {
                    Auth::logoutOtherDevices($request->password);
                    return redirect()->route('profile')->withSuccess('Logged in Successfully.');
                }
                return redirect()->back()->withError('Account not activated.');
            }
            return redirect()->back()->withError('Invalid credentials.');
        }
    }

    public function forgotpassword(Request $request)
    {
        switch (true) {
            case $request->isMethod('GET'):
                return view('site.auth.forgotpassword');
                break;

            case $request->isMethod('POST'):
                $rules = [
                    'forgot_mail' => 'required|email|exists:users,email',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    $user = User::where('email', $request->input('forgot_mail'))->first();
                    $subject = ucwords(str_replace('-', ' ', env('APP_NAME'))) . ' - Password Recovery';
                    $mailFromId = (config()->get('mail.from.address') != '') ? config()->get('mail.from.address') : env('MAIL_FROM_ADDRESS');
                    $txt = '';
                    $txt .= '<p>Welcome ' . $user->name . '</p>';
                    $txt .= '<p>Password Recovery For Your Email-iD: ' . $request->forgot_mail . '.<br>Please </p>';
                    $txt .= '<p><a href="' . route('password.recovery', ['rowid' => Crypt::encryptString($user->id)]) . '">Click here & Change You Password From Here....</a></p>';
                    try {
                        $d = Mail::to($request->forgot_mail)->send(new GeneralMail($user->name, $mailFromId, $txt, $subject));
                        User::where('email', $request->input('forgot_mail'))->update(['email_verified_at' => date('Y-m-d H:i:s')]);
                        return redirect()->back()->withSuccess('A password recovery mail sent to ' . $request->forgot_mail);
                    } catch (\Throwable $th) {
                        return redirect()->back()->withError('SMTP Eror occured.Email not Send. ' . $th->getMessage());
                    }
                }
                break;
        }
    }

    public function passwordrecovery(Request $request, $rowid = null)
    {
        switch (true) {
            case $request->isMethod('GET'):
                $rowid = Crypt::decryptString($rowid);
                $data['user'] = $user = User::find($rowid);
                if (!empty($user) && ($user->email_verified_at != '')) {
                    $tkn = date('Y-m-d h:i', strtotime($user->email_verified_at));
                    $exptkn = date('Y-m-d h:i', strtotime('+3 minutes', strtotime($user->email_verified_at)));
                    $current = date('Y-m-d h:i');
                    if (strtotime($current) >= strtotime($tkn) && strtotime($current) <= strtotime($exptkn)) {
                        return view('site.auth.passwordrecovery', @$data);
                    } else {
                        return redirect()->route('login_user')->withError('Link Expired');
                    }
                }
                return redirect()->back()->withError('Something went wrong.');
                break;

            case $request->isMethod('POST'):
                $rules = [
                    'recovery_mail' => 'required|email|exists:users,email',
                    'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
                    'confirm_password' => 'required|same:password'
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withInputs($request->all())->withErrors($validator->errors());
                } else {
                    if (User::where([['id', '=', $request->rowid], ['email', '=', $request->recovery_mail]])->update([
                        'password' => Hash::make($request->password)
                    ])) {
                        return redirect()->route('login_user')->withSuccess('Password Successfully Reset.');
                    }
                    return redirect()->back()->withError('Something went wrong. Password not reset');
                }
                break;

            default:
                abort(403, 'Unauthorized action.');
                break;
        }
    }

    public function profile(Request $request, $rowid = null)
    {
        $uId = Auth()->id();
        $data['profile'] = User::where('id', $uId)->first();
        return view('site.auth.profile', @$data);
    }

    public function sign_up(Request $request)
    {
        return view('site.auth.register');
    }
    public function refreshCaptcha(Request $request)
    {
        return response()->json(['captcha' => captcha_img('math')]);
    }
    public function postRegistration(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'password' => 'required|min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|same:password',
            'captcha' => 'required|captcha'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 0, "msg" => $validator->errors()->first()]);
        }

        $adminUser = User::where('user_type_id', 1)->where('status', 'A')->first();

        $UserData = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type_id' => 0,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'post_code' => $request->post_code,
            'created_at' => now(),
        ]);

        if ($UserData) {
            // Generate a signed verification link
            $verificationLink = URL::temporarySignedRoute(
                'email.verify',
                Carbon::now()->addMinutes(5), // Link expires in 60 minutes
                ['id' => $UserData->id]
            );

            // Send verification email
            $data = [
                'to_name' => $request->name,
                'to_email' => $request->email,
                'verification_link' => $verificationLink,
                'to_content' => "Click the link below to verify your email and log in:\n$verificationLink",
            ];
            Mail::to($data['to_email'])->send(new RegisterMail($data));

            // Notify admin about new user registration
            if ($adminUser) {
                $data['to_content'] = "A New User Has Registered: {$request->name}. Details are below.";
                Mail::to($adminUser->email)->send(new NewRegisterMail($data));
            }

            return response()->json(['status' => 1, "msg" => "Registration successful. Please check your email for verification."]);
        }

        return response()->json(['status' => 0, "msg" => "There is something wrong!"]);
    }

    public function verifyEmail(Request $request, $id)
    {
        if (! $request->hasValidSignature()) {
            return redirect('/')->with('error', 'Invalid or expired verification link.');
        }
    
        $user = User::find($id);
    
        if (!$user) {
            return redirect('/')->with('error', 'User not found.');
        }
    
        if ($user->email_verified_at) {
            return redirect('/login')->with('info', 'Your email is already verified. Please log in.');
        }
    
        // Mark email as verified
        $user->email_verified_at = now();
        $user->save();
    
        Auth::login($user); // Log the user in automatically
    
        return redirect('login')->with('success', 'Your email has been verified successfully.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login_user')->withSuccess('You are now logged out of the system.');
    }
}
