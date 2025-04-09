<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        switch (true) {
            case $request->isMethod('GET'):
                $data['setting'] = Setting::first();
                return view('admin.panel.setting.index', @$data);
                break;

            case $request->isMethod('POST'):
                if ($request->type == 'siteinfo') :
                    $rules = [
                        'site_name' => 'required',
                        'site_mail' => 'nullable|email',
                        'contact_no' => 'nullable',
                        'site_address' => 'nullable',
                        'footer_text' => 'nullable',
                        'site_image' => 'nullable|image|mimes:webp,png,jpeg,gif,jpg',
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $validator->errors()->add('setting_err', '1');
                        $validator->errors()->add('setting_type', $request->type);
                        return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                    } else {
                        $filename = 'noimg.png';
                        if ($request->hasFile('site_image')) {
                            $upPath = 'uploads/setting/';
                            $file = $request->file('site_image');
                            $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                            if (!file_exists(public_path($upPath))) {
                                mkdir(public_path($upPath), 0777, true);
                            }
                            $file->move(public_path($upPath), $filename);
                        } else {
                            $filename = @Setting::where([['id', '=', $request->rowid]])->first()->logo;
                            $filename = $filename == null ? 'noimg.png' : $filename;
                        }
                        if (Setting::updateOrCreate(['id' => $request->rowid], [
                            'site_name' => $request->site_name,
                            'logo' => $filename,
                            'site_mail' => $request->site_mail,
                            'contact_no' => $request->contact_no,
                            'site_address' => $request->site_address,
                            'footer_text' => $request->footer_text,
                        ])) {
                            return redirect()->back()->withSuccess('Site Info Saved.');
                        }
                        return redirect()->back()->withError('Something went wrong.');
                    }
                endif;
                if ($request->type == 'metainfo') :
                    $rules = [
                        'meta_title' => 'nullable|max:255',
                        'meta_keyword' => 'nullable|max:255',
                        'meta_description' => 'nullable|max:255',
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $validator->errors()->add('setting_err', '1');
                        $validator->errors()->add('setting_type', $request->type);
                        return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                    } else {
                        if (Setting::updateOrCreate(['id' => $request->rowid], [
                            'meta_title' => $request->meta_title,
                            'meta_keyword' => $request->meta_keyword,
                            'meta_description' => $request->meta_description,
                        ])) {
                            return redirect()->back()->withSuccess('Meta Info Saved.');
                        }
                        return redirect()->back()->withError('Something went wrong.');
                    }
                endif;
                if ($request->type == 'socialinfo') :
                    $rules = [
                        'insta_link' => 'nullable|max:255',
                        'fb_link' => 'nullable|max:255',
                        'twitter_link' => 'nullable|max:255',
                        'linkdin_link' => 'nullable|max:255',
                        'youTube_link' => 'nullable|max:255'
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $validator->errors()->add('setting_err', '1');
                        $validator->errors()->add('setting_type', $request->type);
                        return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                    } else {
                        if (Setting::updateOrCreate(['id' => $request->rowid], [
                            'insta_link' => $request->insta_link,
                            'fb_link' => $request->fb_link,
                            'twitter_link' => $request->twitter_link,
                            'linkdin_link' => $request->linkdin_link,
                            'you_tube_link' => $request->youTube_link
                        ])) {
                            return redirect()->back()->withSuccess('Social Info Saved.');
                        }
                        return redirect()->back()->withError('Something went wrong.');
                    }
                endif;
                if ($request->type == 'smtpinfo') :
                    $rules = [
                        'smtp_host' => 'required|max:255',
                        'smtp_port' => 'nullable|max:255',
                        'smtp_name' => 'nullable|max:255',
                        'smtp_username' => 'nullable|max:255',
                        'smtp_pass' => 'nullable|max:255',
                        'smtp_formadd' => 'nullable|max:255',
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $validator->errors()->add('setting_err', '1');
                        $validator->errors()->add('setting_type', $request->type);
                        return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                    } else {
                        if (Setting::updateOrCreate(['id' => $request->rowid], [
                            'smtp_host' => $request->smtp_host,
                            'smtp_port' => $request->smtp_port,
                            'smtp_name' => $request->smtp_name,
                            'smtp_username' => $request->smtp_username,
                            'smtp_pwd' => $request->smtp_pass,
                            'smtp_form_address' => $request->smtp_formadd,
                        ])) {
                            return redirect()->back()->withSuccess('SMTP Info Saved.');
                        }
                        return redirect()->back()->withError('Something went wrong.');
                    }
                endif;
                if ($request->type == 'detailsinfo') :
                    $rules = [
                        'have_question' => 'required|min:5',
                        'other_ervices' => 'required|min:5',
                        'contact_us' => 'required|min:5',
                        'newsletter' => 'required|min:5',
                        'about_company' => 'required|min:5'
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $validator->errors()->add('setting_err', '1');
                        $validator->errors()->add('setting_type', $request->type);
                        return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                    } else {
                        $filename = 'noimg.png';
                        if ($request->hasFile('contact_us_icon')) {
                            $upPath = 'uploads/setting/brand_logo';
                            $file = $request->file('contact_us_icon');
                            $contactUs = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                            if (!file_exists(public_path($upPath))) {
                                mkdir(public_path($upPath), 0777, true);
                            }
                            $file->move(public_path($upPath), $contactUs);
                        } else {
                            $contactUs = @Setting::where([['id', '=', $request->rowid]])->first()->contact_us_icon;
                            $contactUs = $contactUs == null ? 'noimg.png' : $contactUs;
                        }

                        

                        if (Setting::updateOrCreate(['id' => $request->rowid], [
                            'have_question' => $request->have_question,
                            'other_ervices' => $request->other_ervices,
                            'contact_us' => $request->contact_us,
                            'newsletter' => $request->newsletter,
                            'about_company' => $request->about_company
                            
                        ])) {
                            return redirect()->back()->withSuccess('Extra Details Added Successfully!!');
                        }
                        return redirect()->back()->withError('Something went wrong.');
                    }
                endif;


                break;

            default:
                abort(403, 'Unauthorized action.');
                break;
        }
    }
}
