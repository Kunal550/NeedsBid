@extends('site.layout.commonLayout')
@section('content')
    <section class="no-overlay innerbanner">
        <figure class="innerbanner-img">
            @if (!empty($subservices[0]->image))
            <img src="{{ asset('public/uploads/sub_service/' . $subservices[0]->image) }}" alt="">
            @else
                <img src="{{ asset('public/uploads/sub_service/noimg.png') }}" alt="">
            @endif
        </figure>
    </section>
    
    <!-- Other Services -->
    <section class="sec-space bg-gray other-ser-head">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 text-center">
                    <h2>{{ $data->name }}</h2>
                    <p>{!! $data->content !!}</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <!-- REPEATE SECTION -->
        @foreach ($subservices as $subservice)
        {{-- {{dd($subservice)}} --}}
            <div class="repeate-section position-relative">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-md-6 img-col">
                            <img src="{{ $subservice->avatar }}" alt="">
                        </div>
                        <div class="col-md-6 text-col ml-lg-auto">
                            <div class="repeat-text-box d-flex align-items-center flex-wrap">
                                <div class="repeat-wrap">
                                    <h3>{{ $subservice->name }}</h3>
                                    <p>{!! $subservice->content !!}</p>
                                    {{-- <a href="{{route('get-service-details',$subservice->slug)}}" class="btn btn-primary mt-lg-4 mt-3">View Colours</a> --}}
                                    <a href="#" class="btn btn-primary mt-lg-4 mt-3">View Colours</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    <section class="latest-work sec-space">
        <div class="container">
            <div class="row bt-gallery-row py-lg-3">
                @foreach ($service_images->serice_to_service_images as $service_image)
                    <div class="col-md-3 col-6 col-sm-4">
                        <a href="{{ asset('public/uploads/service_images/' . $service_image->service_images) }}"
                            class="gbox fancybox" data-fancybox="gallery">
                            <img src="{{ asset('public/uploads/service_images/' . $service_image->service_images) }}"
                                alt="">
                            <div class="view-gal"></div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="quotation sec-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-lg-9 text-center">
                    <h2>Have A Question?</h2>
                    <p>{!! $setting->have_question !!}</p>
                    <a href="{{ route('contactus') }}" class="btn btn-white">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
@endsection
