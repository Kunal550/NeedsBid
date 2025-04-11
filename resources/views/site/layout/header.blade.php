<?php
$setting = App\Models\Setting::first();
?>
<header id="Header" class="site-header">
    <div class="top-menu">
        <div class="container">
            <div class="row ">
                <div class="col-sm-6 top-left-menu">
                    <ul>
                        <li><img src="{{ asset('public/uploads/images/mail-icon.svg') }}" /><a href="mailto:{{ $setting->site_mail }}">{{ $setting->site_mail }}</a></li>

                        <li><img src="{{ asset('public/uploads/images/call-icon.svg')}}" /><a href="tel:{{ $setting->contact_no }}">{{ $setting->contact_no }}</a></li>
                    </ul>
                </div>

                <div class="col-sm-6 top-right-menu">
                    <ul>
                        <li>
                            @if (!empty($setting->fb_link))
                            <a href="{{ $setting->fb_link }}" target="_blank"><img src="{{ asset('public/uploads/images/f.svg')}}" /></a>
                            @endif
                        </li>
                        <li>
                            @if (!empty($setting->insta_link))
                            <a href="{{ $setting->insta_link }}" target="_blank"><img src="{{ asset('public/uploads/images/icon1.svg')}}" /></a>
                            @endif
                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('public/uploads/images/in.svg')}}" /></a>

                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('public/uploads/images/you-tube.svg')}}" /></a>
                        </li>
                        <li> @if (!empty($setting->twitter_link))
                            <a href="{{ $setting->twitter_link }}" target="_blank"><img src="{{ asset('public/uploads/images/twitter.svg')}}" /></a>
                            @endif


                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<div class="header-bottom">
        <div class="container">
            <div class="row align-item-center">
                <div class="col-sm-10 header-left-menu">
                    <div class="header-logo">
                        <a href="{{ route('/') }}">
                            <img src="{{ asset('public/uploads/images/logo.svg')}}" alt="" />
                        </a>
                    </div>

                    <div class="header-bottom-left">
                        <ul id="menu-menu-1" class="">
                            <li id="" class=""><a href="{{ route('/') }}" aria-current="page">Home</a></li>
                            <li id="" class=""><a href="{{ route('about-us') }}">About Us</a></li>
                            <li id="" class=""><a href="{{ route('contact-us') }}">Contact Us</a></li>
                            <li id="" class=""><a href="{{route('contractors')}}">Find Contactors</a></li>
                            <li id="" class=""><a href="{{route('find-project')}} ">Find Projects</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="login-button">
                        @if(auth()->check())
                        <a href="{{ route('profile') }}"><span>Profile</span></a>
                        @else
                        <a href="{{ route('login_user') }}"><span>Login</span></a>
                        @endif
                    </div>
                </div>
            </div>
    </div>
</div>
   
</header>