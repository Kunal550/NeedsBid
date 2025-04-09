@extends('site.layout.commonLayout')
@section('content')
    <section class="innerbanner">
        <div class="container">
            <div class="text-center innerbanner-text">
                <h2>Latest Work</h2>
                <div class="breadcrumb-box">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Latest Work</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="latest-work sec-space pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 text-center mb-lg-5 mb-3">
                    <h2>Our Latest Work</h2>
                    <p>{!! $setting->our_latest_work !!}</p>
                </div>
            </div>
            <div class="owl-carousel gal-slider">
                @foreach ($latestWorks as $our_latest_work)
                    <div class="item">
                        <a href="{{ asset('public/uploads/latest_work/' . $our_latest_work->image) }}" class="gbox fancybox"
                            data-fancybox="gallery">
                            <img src="{{ asset('public/uploads/latest_work/' . $our_latest_work->image) }}" alt="">
                            <div class="view-gal"></div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
