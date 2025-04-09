@php
    $setting = App\Models\Setting::first();
    $project_categories = App\Models\ProjectCategory::where([['status',  'A']])->get();
@endphp
<div class="news-latter-section">
    <h2 class="common-heading text-center wow bounceInRight color-white">Newsletter</h2>
    <p class="news-sub-text1"> {!! $setting->newsletter !!}
    </p>
    <form action="{{ route('news-letter') }}" id="news-letter" method="get">
    <div class="news-latter-section-one">
        <input type="email" name="news_letter_email" class="news-search" placeholder="Email" />
        <input type="submit" class="news-submit-one" />
    </div>
    </form>
</div>
<footer id="colophon" class="site-footer footer-bg common-gap">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="footer-logo wow bounceInRight">
                    <a href="{{ route('/') }}">
                        <img src="{{ asset('public/uploads/setting/' . $setting->logo) }}" alt="" />
                    </a>
                </div>
                <div class="footer-logo-text wow bounceInRight">
                {!! $setting->about_company !!}
                </div>
                <div class="social-media-icon wow bounceInRight">

                @if (!empty($setting->fb_link))
                        <a href="{{ $setting->fb_link }}" target="_blank"><img src="{{ asset('public/uploads/images/facebook-icon1.svg')}}" alt="" /></a>
                    @endif
                    @if (!empty($setting->linkdin_link))
                        <a href="{{ $setting->linkdin_link }}" target="_blank"><img src="{{ asset('public/uploads/images/ins-1.svg')}}" alt="" /></a>
                    @endif
                    @if (!empty($setting->twitter_link))
                        <a href="{{ $setting->twitter_link }}" target="_blank"><img src="{{ asset('public/uploads/images/you-tube2.svg')}}" alt="" /></a>
                    @endif
                    @if (!empty($setting->insta_link))
                        <a href="{{ $setting->insta_link }}" target="_blank"><img src="{{ asset('public/uploads/images/ins-1.svg')}}" alt="" /> </a>
                    @endif
                    @if (!empty($setting->you_tube_link))
                        <a href="{{ $setting->you_tube_link }}" target="_blank"><img src="{{ asset('public/uploads/images/you-tube1.svg')}}" alt="" /> </a>
                    @endif
                </div>
            </div>
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-6 footer-text1 quick-link wow bounceInRight">
                        <h2>Quick Links</h2>
                        <ul>
                            <li><a href="{{ route('/') }}">Home</a></li>
                            <li><a href="{{ route('about-us') }}">About</a></li>
                            <li><a href="#">Contractors</a></li>
                            <li><a href="{{ route('contact-us') }}">Contact</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li><a href="{{ route('faqs') }}">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 footer-text1">
                        <h2>Industries We Serve</h2>
                        
                        @foreach ($project_categories as $project_category)
                        <ul>
                            <li><a href="{{route('project-details',$project_category->slug)}}">{{ $project_category->name }}</a></li>
                        </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-4 ">
                <div class="contact-us-now">
                    <h2>Contact Info</h2>
                    <ul>
                        <li>
                            <img src="{{ asset('public/uploads/images/location1.svg')}}" alt="" />
                            <p>  {{ $setting->site_address }} </p>
                        </li>
                        <li>
                            <img src="{{ asset('public/uploads/images/tale-phone1.svg')}}" alt="" />
                            <p> <a href="tel:{{ $setting->contact_no }}">{{ $setting->contact_no }}</a> </p>
                        </li>
                        <li>
                            <img src="{{ asset('public/uploads/images/mail-icon2.svg')}}" alt="" />
                            <p> <a href="mailto:{{ $setting->site_mail }}">{{ $setting->site_mail }}</a> </p>
                        </li>
                        <li>
                            <img src="{{ asset('public/uploads/images/time-icon.svg')}}" alt="" />
                            <p> Mon - Sat : 09.00am - 07.00pm Sun : Close </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>