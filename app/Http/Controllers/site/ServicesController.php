<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Our_latest_work;
use App\Models\Sub_service;
use App\Models\Setting;
use App\Models\TestimonialModel;

class ServicesController extends Controller
{
    public function OtherServices(Request $request)
    {
        $data['otherservices'] = Service::where('status', 'A')->get();
        $data['setting'] = Setting::first();
        return view('site.service.otherservice', $data);
    }
    
    public function testimonial(Request $request)
    {
        $data['testis'] = TestimonialModel::where('status', 'A')->get();
        return view('site.service.testimonial', $data);
    }

    public function latestWork(Request $request)
    {
        $data['latestWorks'] = Our_latest_work::where('status', 'A')->get();
        $data['setting'] = Setting::first();
        return view('site.pages.latestWork', $data);
    }
}
