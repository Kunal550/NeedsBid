<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Banner;
use App\Models\ContactUsModel;
use App\Models\Setting;
use App\Models\PageModel;
use Carbon\Carbon;
use App\Models\BlogModel;
use App\Models\HowItWorkModel;
use App\Models\ContentModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ConstructionTypeModel;
use App\Models\ContactorModel;
use App\Models\FaqModel;
use App\Models\NewsLetter;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\TestimonialModel;

class HomeController extends Controller
{
    public function index()
    {
        $data['banners'] = Banner::where([['status',  'A']])->get();
        $data['blogs'] = BlogModel::where([['status',  'A']])->get();
        $data['setting'] = Setting::first();
        $data['how_it_works'] = HowItWorkModel::where([['status',  'A']])->latest()->take(4)->get();
        $data['testimonials'] = TestimonialModel::where([['status',  'A']])->get();
        $data['project_categories'] = ProjectCategory::where([['status',  'A']])->get();
        $data['content_below_brands'] = ContentModel::where([['status',  'A'], ['is_below_brand', 1]])->first();
        $data['content_below_featured'] = ContentModel::where([['status',  'A'], ['is_below_brand', 2]])->first();
        return view('site.home.index', $data);
    }

    public function Contractors(Request $request)
    {
        $contractor = $request->contractor;
        $project_category = $request->project_category;
        $data['contractorCheckBox'] = [];
        $data['project_categoryCheckBox'] = [];
        $contractorId = [];
        $project_categoryId = [];

        if (!empty($contractor)) {
            $data['contractorCheckBox'] = ContactorModel::when($contractor, function ($query, $contractor) {
                return $query->whereIn('slug', $contractor);
            })->where('status', 'A')->get();
        }

        if (!empty($data['contractorCheckBox'])) {
            foreach ($data['contractorCheckBox'] as $contractorBox) {
                $contractorId[] = $contractorBox->id;
            }
        }


        if (!empty($project_category)) {
            $data['project_categoryCheckBox'] = ProjectCategory::when($project_category, function ($query, $project_category) {
                return $query->whereIn('slug', $project_category);
            })->where('status', 'A')->get();
        }

        if (!empty($data['project_categoryCheckBox'])) {
            foreach ($data['project_categoryCheckBox'] as $project_categoryBox) {
                $project_categoryId[] = $project_categoryBox->id;
            }
        }

        // Fixed groupBy and whereIn logic
        $projects = Project::select('projects.id', 'projects.slug', 'projects.title', 'projects.description','states.name as stateName','contractors_model.name as contractor_name', 'projects.budget', 'projects.bid_deadline', 'projects.image')
            ->leftJoin('contractors_model', 'projects.contractor_trade', '=', 'contractors_model.id')
            ->leftJoin('project_categories', 'projects.category_id', '=', 'project_categories.id')
            ->leftJoin('states', 'projects.state_id', '=', 'states.id')
            ->where('projects.status', 'A')
            ->groupBy('projects.id')
            ->when($request->contractor_search != '', function ($query) use ($request) {
                $query->where('contractors_model.name', 'like', "%{$request->contractor_search}%");
            });
        if (!empty($contractorId)) { 
            $projects = $projects->whereIn('projects.contractor_trade', $contractorId);
        }
        if (!empty($project_categoryId)) { 
            $projects = $projects->whereIn('projects.category_id', $project_categoryId);
        }

        $projects = $projects->paginate(10);

        // Other data fetching
        $data['projects'] = $projects;
        $data['project_categories'] = ProjectCategory::where([['status', '!=', 'D']])->get();
        $data['contractors'] = ContactorModel::where([['status', '!=', 'D']])->get();
        $data['constructors'] = ConstructionTypeModel::where([['status', '!=', 'D']])->get();

        return view('site.home.contractors', $data);
    }

    public function findProject(Request $request)
    {
        $data['projects'] = Project::where([['status',  'A']])->paginate(10);
        return view('site.home.find_project',$data);
    }

   

    


    public function GetBlogDetails(Request $request, $slug)
    {
        $data['blog_details'] = BlogModel::where('slug', $slug)->first();
        return view('site.pages.blog_details', $data);
    }

    public function GetProjectCategoryDetails(Request $request, $slug)
    {
        $data['project_details'] = ProjectCategory::where('slug', $slug)->first();
        return view('site.pages.project_category', $data);
    }

    public function TermsAndConditation(Request $request)
    {
        $terms_and_conditaion = 'terms-and-conditions';
        $data['terms'] = PageModel::where('slug', $terms_and_conditaion)->first();
        return view('site.home.terms_conditation', $data);
    }
    public function PrivacyPolicy(Request $request)
    {
        $privacy = 'privacy-policy';
        $data['privacy'] = PageModel::where('slug', $privacy)->first();
        return view('site.home.privacy', $data);
    }

    public function AboutUs(Request $request)
    {
        $aboutUs = 'about-us';
        $data['data'] = PageModel::where('slug', $aboutUs)->first();
        return view('site.home.about_us', $data);
    }

    public function blog(Request $request)
    {
        $data['blogs'] = BlogModel::where('status', 'A')->get();
        return view('site.home.blog', $data);
    }
    
    public function newsLetter(Request $request)
    {
        NewsLetter::create([
            'email' => $request->news_letter_email
        ]);
        return redirect()->back()->withSuccess('News Letter Added successfully.');
    }

    public function faq(Request $request)
    {
        $data['datas']= FaqModel::where('status', 'A')->get();
        return view('site.home.faq', $data);
    }

    
    public function Contactus(Request $request)
    {
        $data['contact_details'] = Setting::first();
        return view('site.home.contact_us', $data);
    }

    public function Account_details(Request $request)
    {

        $uId = Auth()->id();
        if (!empty($uId)) {
            $data['profile'] = User::where('id', $uId)->first();
            return view('site.home.edit_account', @$data);
        } else {
            return view('errors.404');
        }
    }
    public function ChangePwd(Request $request)
    {
        $uId = Auth()->id();
        if (!empty($uId)) {
            $data['profile'] = User::where('id', $uId)->first();
            return view('site.home.changePwd', @$data);
        } else {
            return view('errors.404');
        }
    }

    public function ChangePwdUpdate(Request $request, $rowid = null)
    {
        $rules = [
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|same:new_password',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            if ($request->has('new_password')) {
                $passwordCheck = Hash::make($request->confirm_password);
                User::where('id', $request->account_id)->update([
                    'password'         =>     Hash::make($request->confirm_password),
                ]);
            }
            return redirect()->route('profile')->withSuccess('Password Updated Successfully');
        }
    }

    public function Account_details_update(Request $request, $rowid = null)
    {
        $rules = [
            'name' => 'required',
            'business_doc' => 'nullable|mimes:pdf|max:10000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $filename = '';
            $profileImage = '';

            if ($request->hasFile('profile_image')) {
                $upPath = 'uploads/admin/';
                $file = $request->file('profile_image');
                $profileImage = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                if (!file_exists(public_path($upPath))) {
                    mkdir(public_path($upPath), 0777, true);
                }
                $file->move(public_path($upPath), $profileImage);
            } else {
                $profileImage = User::where([['id', '=', $request->account_id]])->first()->profile_image;
                $profileImage = $profileImage == null ? 'noimg.png' : $profileImage;
            }
            

            $data = User::where('id', $request->account_id)->update([
                'name'             =>   $request->name,
                'email'             => $request->email,
                'phone'         =>     $request->phone,
                'address'         =>     $request->address,
                'post_code'         =>     $request->post_code,
                'company_info'         =>     $request->company_info,
                'contact_details'         =>     $request->contact_details,
                'profile_image' => $profileImage,
                'business_doc' => $filename
            ]);

            if ($data) {
                if ($request->has('showPassword')) {
                    $passwordCheck = Hash::make($request->confirm_password);
                    User::where('id', $request->account_id)->update([
                        'password'         =>     Hash::make($request->confirm_password),

                    ]);
                }
                return redirect()->route('profile')->withSuccess('Account Updated Successfully');
            } else {
                return redirect()->back()->withError('Something went wrong.');
            }
        }
    }
    public function BusinessDoc(Request $request)
    {
        $uId = Auth()->id();
        $data['business_docs'] = User::where('id', $uId)->first();
        return view('site.home.edit_businessdocs', @$data);
    }

    public function UpdateBusinessDoc(Request $request, $rowid = null)
    {
        if ($request->hasFile('business_doc')) {
            $upPath = 'uploads/business_doc/';
            $file = $request->file('business_doc');
            $filename = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path($upPath))) {
                mkdir(public_path($upPath), 0777, true);
            }
            $file->move(public_path($upPath), $filename);
        } else {
            $filename = User::where([['id', '=', $request->account_id]])->first()->business_doc;
            $filename = $filename == null ? 'noimg.png' : $filename;
        }
        $data = User::where('id', $request->account_id)->update([
            'business_doc' => $filename
        ]);
        if ($data) {
            return redirect()->back()->withSuccess('Business Docs Updated Successfully');
        } else {
            return redirect()->back()->withError('Something went wrong.');
        }
    }

    public function submitContactForm(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make(
            $inputs,
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required'
            ]
        );
        if ($validator->fails()) {
            $message = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $data = ContactUsModel::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_id' => Auth::user()->id,
                'how_can_we_help' => $request->how_can_we_help
            ]);
            if (!empty($data)) {
                return redirect()->back()->withSuccess('Thank you for contact us. we will contact you shortly.');
            } else {
                return redirect()->back()->withErrors('There is something wrong!');
            }
        }
    }
}
