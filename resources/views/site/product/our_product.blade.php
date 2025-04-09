@extends('site.layout.commonLayout')
@section('content')
    <section class="innerbanner no-overlay">
        <figure class="innerbanner-img"><img src="{{ asset('public/uploads/category/' . $categories[0]->category_image) }}" alt="">
        </figure>
    </section>

    <section class="kitchen-materials sec-space pb-0 pb-lg-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 text-center mb-lg-5 mb-4">
                    <h2>Kitchen Worktop Materials</h2>
                    <p>{!! $setting->kitchen_worktop_materials !!}</p>
                </div>
            </div>
        </div>
        <div>
            <div class="row material-row">
                @foreach ($categories as $cat)
                    <div class="col-sm-6 col-lg-4">
                        <div class="material-box">
                            <figure><a href="{{ route('getCategoryProduct', $cat->slug) }}"><img
                                        src="{{ asset('public/uploads/category/' . $cat->category_image) }}"
                                        alt=""></a></figure>
                            <div class="material-text text-center">
                                <h4>{{ $cat->name }}</h4>
                                <a href="{{ route('getCategoryProduct', $cat->slug) }}" class="btn btn-white">View
                                    Collection</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Other Application -->
    <section class="other-application sec-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 text-center mb-4 mb-lg-5">
                    <h2>Other Applications For Stone Materials</h2>
                    <p>{!! $setting->other_applications_for_stone_materials !!}</p>
                </div>
            </div>

            <div class="row other-application-row justify-content-center">
                @foreach ($otherservices as $otherservice)
                    <div class="col-sm-6 col-md-6">
                        <div class="material-box">
                            <figure><a href="{{ route('ServiceDetails', $otherservice->slug) }}"><img
                                        src="{{ asset('public/uploads/service/' . $otherservice->image) }}"
                                        alt=""></a></figure>
                            <div class="application-text">
                                <h5><a
                                        href="{{ route('ServiceDetails', $otherservice->slug) }}">{{ $otherservice->name }}</a>
                                </h5>
                                <p><a href="{{ route('ServiceDetails', $otherservice->slug) }}">{!! substr($otherservice->content, 0, 150) !!}..</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="quotation sec-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-lg-9 text-center">
                    <h2>Have Plans & Need A Quotation?</h2>
                    <p>{!! $setting->have_plans !!}</p>
                    <a href="#" class="btn btn-white">Upload Plans Online</a>
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
                @foreach ($our_latest_works as $our_latest_work)
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

    <section class="brands sec-space">
        <div class="container">
            <div class="text-center mb-lg-4 mb-4">
                <h3>Brands We Supply</h3>
            </div>
            <div class="owl-carousel dot-none brand-slider">
                @foreach ($brands as $brand)
                    <div class="item">
                        <figure class="brand-icon">
                            <a href="{{ route('brand-wise-product', $brand->slug) }}">
                                <img src="{{ asset('public/uploads/brand/' . $brand->brand_image) }}" alt="">
                            </a>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    </section>
@endsection
