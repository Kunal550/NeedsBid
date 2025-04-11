@extends('site.layout.commonLayout')
@section('content')
<section>
    <div class="banner-section banner login-banner">
        <div class="">
            <div class="">
                @foreach ($banners as $banner)
                <figure>
                    <img src="{{ asset('public/uploads/banner/'. $banner->image)}}" alt="" />
                    @endforeach
                    <div class="banner-contain">
                        <div class="bannerinner-contain">
                            <h1 class="banner-heading-text1 wow bounceInRight">{{ $banner->title }}</h1>
                            <div class="search-section-main iner-section-main mt-5">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="inner-search-one">
                                            <input type="text" class="search-section-main1" placeholder="Search For Contracters">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="button" value="search" class="search-button search-button-inner">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
<div class="why-choose-section common-padding" style="background: url('{{ asset('public/uploads/images/square-dotted-world-map-and-earth-globes.png') }}' no-repeat;">
    <div class="container">

        <h3 class="common-sub-heading wow bounceInRight text-center">Essential Tools for Streamlined Success</h3>
        <h2 class="common-heading wow bounceInRight text-center">Why Choose Need<span>Bids</span></h2>
        <div class="row pt-5">


            @foreach ($how_it_works as $how_it_work)
            <div class="col-sm-3">
                <div class="figure-icon wow bounceInRight">
                    <img src="{{ $how_it_work->avatar }}" alt="" />
                </div>
                <p class="why-choose-description wow bounceInRight">{!! $how_it_work->description !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
<div class="container">



    <div class="home-page">
        <div class="how-need-birds ">
            <div class="row align-items-center">
                <div class="col-sm-6 wow bounceInLeft">
                    @if (!empty($content_below_brands->content_images))
                    <img src="{{ asset('public/uploads/content_images/' . $content_below_brands->content_images) }}"
                        alt="">
                    @else
                    <img src="{{ asset('public/uploads/content_images/noimg.png') }}" alt="">
                    @endif
                </div>
                <div class="col-sm-6 wow bounceInLeft">
                    <div class="how-needs-birds">
    
                        <p>{!! $content_below_brands->description !!}</p>
                        <div class="get-started-now">
                            <a href="{{ $content_below_brands->button_link }}" class="get-started-button wow bounceInLeft"><span>{{ $content_below_brands->button_name }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="our-powerfull"
        style="background: url('{{ asset('public/uploads/images/square-dotted-world-map-and-earth-globes1.png') }}') no-repeat;">
        <div class="col-sm-5 mx-auto">
            <h3 class="common-sub-heading text-center wow bounceInLeft">Essential Tools for Streamlined Success</h3>
            <h2 class="common-heading text-center wow bounceInLeft">
                <span>Our Powerful Features to Boost</span> Your Project
            </h2>
        </div>

    </div>
    <div class="container">
        <div class="row pt-5">
            <div class="col-sm-3">
                <div class="our-power-full-section">
                    <figure class="our-power-full-section-img wow bounceInLeft">
                        <img src="{{asset('public/uploads/images/our-powerfull-img.png')}}" alt="" />
                    </figure>
                    <div class="our-power-full-section-text">
                        <h2 class="wow bounceInLeft project-heading-text text-center">Project Matching</h2>
                        <p class="wow bounceInLeft project-description-text">Never miss a deadline with seamless
                            calendar integration. Sync project schedules, bid dates, and meetings across tools like
                            Google Calendar or Outlook.</p>
                        <div class="get-started-now">
                            <a href="#" class="get-started-button wow bounceInLeft"><span>Get Started Now</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="our-power-full-section">
                    <figure class="our-power-full-section-img wow bounceInLeft">
                        <img src="{{asset('public/uploads/images/our-powerfull-img.png')}}" alt="" />
                    </figure>
                    <div class="our-power-full-section-text">
                        <h2 class="wow bounceInLeft project-heading-text text-center">Takeoff & Estimating Tools
                        </h2>
                        <p class="wow bounceInLeft project-description-text">Never miss a deadline with seamless
                            calendar integration. Sync project schedules, bid dates, and meetings across tools like
                            Google Calendar or Outlook.</p>
                        <div class="get-started-now">
                            <a href="#" class="get-started-button wow bounceInLeft"><span>Get Started Now</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="our-power-full-section">
                    <figure class="our-power-full-section-img wow bounceInLeft">
                        <img src="{{asset('public/uploads/images/our-powerfull-img.png')}}" alt="" />
                    </figure>
                    <div class="our-power-full-section-text">
                        <h2 class="wow bounceInLeft project-heading-text text-center">Reputation Management</h2>
                        <p class="wow bounceInLeft project-description-text">Never miss a deadline with seamless
                            calendar integration. Sync project schedules, bid dates, and meetings across tools like
                            Google Calendar or Outlook.</p>
                        <div class="get-started-now">
                            <a href="#" class="get-started-button wow bounceInLeft"><span>Get Started Now</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="our-power-full-section">
                    <figure class="our-power-full-section-img wow bounceInLeft">
                        <img src="{{asset('public/uploads/images/our-powerfull-img.png')}}" alt="" />
                    </figure>
                    <div class="our-power-full-section-text">
                        <h2 class="wow bounceInLeft project-heading-text text-center">Calendar Integration</h2>
                        <p class="wow bounceInLeft project-description-text">Never miss a deadline with seamless
                            calendar integration. Sync project schedules, bid dates, and meetings across tools like
                            Google Calendar or Outlook.</p>
                        <div class="get-started-now ">
                            <a href="#" class="get-started-button wow bounceInLeft"><span>Get Started Now</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="discover-button-section position-relative text-center common-padding">
    <div class="get-started-now">
        <a href="#" class="get-started-button wow bounceInLeft m-0"><span>Discover More Features</span></a>
    </div>
</div>
<div class="eqal-bg common-padding" style="background: url('{{ asset('public/uploads/images/equal-bg.png') }}') no-repeat;">
    <div class="container">
        <div class="row align-item-center">

            <div class="col-sm-6">
                <div class="equal-video position-relative">
                    @if (!empty($content_below_featured->content_images))
                    <img src="{{ asset('public/uploads/content_images/' . $content_below_featured->content_images) }}"
                        alt="">
                    @else
                    <img src="{{ asset('public/uploads/content_images/noimg.png') }}" alt="">
                    @endif
                    <div class="video-icon1 ">
                        <a href="" class="wow bounceInLeft"> <img src="{{asset('public/uploads/images/video-icon1.svg')}}"
                                alt="" /></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="equal-text1">
                    <div class="color-white">{!! $content_below_featured->description !!}</div>
                    <div class="get-started-now w-100 wow bounceInLeft">
                        <a href="{{ $content_below_featured->button_link }}" class="get-started-button wow bounceInLeft m-0"><span>{{ $content_below_featured->button_name }}</span></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="find-equal-section common-padding">
    <div class="container">
        <div class="col-sm-6 mx-auto">
            <h3 class="common-sub-heading text-center">Expand into New Verticals, Connect with Top Contractors
                Efficiently</h3>
            <h2 class="common-heading text-center">Find Contractors By Industries</h2>
        </div>
        <div class="industry-contain pt-5">

            <div class="fadeOut owl-carousel owl-theme owl-two">

                @foreach ($project_categories as $project_category)
                <div class="item">
                <a href="{{route('project-details',$project_category->slug)}}" class="blog-box">
                    <div class="industry-con1">
                        <figure class="position-relative image-overlay">
                            <img src="{{ $project_category->avatar }}" alt="" />
                            <h2 class="industry-con-heading">{{ $project_category->name }}</h2>
                        </figure>
                    </div>
                </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
<div class="trasted-bg1 common-padding" style="background: url('{{ asset('public/uploads/images/trusted-bg1.png') }}') no-repeat;">
    <div class="container">
        <div class="col-sm-6 mx-auto common-padding pt-0">
            <h3 class="common-sub-heading text-center white-color">Real Experiences from Our Community</h3>
            <h2 class="common-heading color-white text-center">Trusted by Contractors and Project Owners</h2>
        </div>
        <div class="row">
            @foreach ($testimonials as $testimonial)
            <div class="col-sm-4">
                <div class="testimonial-contain">
                    <figure>
                        <img src="{{ $testimonial->avatar }}" alt="">
                    </figure>
                    <h4 class="testimonial-heading text-center wow bounceInLeft">{{ $testimonial->name }}</h4>
                    <h5 class="sub-heading-text text-center wow bounceInLeft">{{ $testimonial->designation }}</h5>
                    <div class="testimonial-description text-center wow bounceInLeft">{!! $testimonial->description !!}</div>
                    <div class="star-icon1 text-center wow bounceInLeft">
                        <img src="{{asset('public/uploads/images/star-icon1.svg')}}" alt="" />
                        <img src="{{asset('public/uploads/images/star-icon1.svg')}}" alt="" />
                        <img src="{{asset('public/uploads/images/star-icon1.svg')}}" alt="" />
                        <img src="{{asset('public/uploads/images/star-icon1.svg')}}" alt="" />

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="our-blog common-padding">
    <div class="container">
        <div class="col-sm-7 mx-auto common-padding pt-0">
            <h3 class="common-sub-heading text-center ">Unlock the Latest in Projects, Construction Tech, and
                Industry Insights</h3>
            <h2 class="common-heading text-center">Our Blogs</h2>
        </div>
        <div class="row">

            @foreach ($blogs as $blog)

            <div class="col-sm-4">
                <div class="our-blog-contain">
                    <div class="blog-main-one position-relative">
                        <figure>
                            <img src="{{ $blog->avatar }}" alt="blog">
                        </figure>
                        <div class="blog-contain-text">
                            <h2 class="blog-heading-text wow bounceInLeft">{{$blog->name }}</h2>
                            <h4 class="blog-description-text">{!! $blog->description !!}</h4>
                            <div class="read-more1">
                                |<a href="{{route('blog-details',$blog->slug)}}" class="readmore-btn">Read More<img src="{{asset('public/uploads/images/arrow-right1.svg')}}" alt="" /></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="discover-button-section position-relative text-center pt-5 pb-5">
    <div class="get-started-now">
        <a href="#" class="get-started-button wow bounceInLeft m-0"><span>View All Blogs</span></a>
    </div>
</div>

@endsection