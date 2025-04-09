@extends('site.layout.commonLayout')
@section('content')
    <section class="no-overlay innerbanner">
        <figure class="innerbanner-img">
            @if (!empty($commercials[0]->image))
                <img src="{{ asset('public/uploads/about/' . $commercials[0]->image) }}" alt="">
            @else
                <img src="{{ asset('public/front_end/images/bathroom-bg.jpg') }}" alt="">
            @endif
        </figure>
    </section>

    <!-- Other Services -->
    <section class="sec-space bg-gray other-ser-head">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 text-center">
                    <h2>{{ $data->name }}</h2>
                    {!! Illuminate\Support\Str::limit($data->description, 300) !!}
                </div>
            </div>
        </div>
    </section>
    <section>

        <!-- REPEATE SECTION -->
        @foreach ($commercials as $commercial)
            <div class="repeate-section position-relative">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-md-6 img-col">
                            @if (!empty($commercial->image))
                            <img src="{{ asset('public/uploads/about/' . $commercial->image) }}" alt="">
                            @else
                            <img src="{{ asset('public/uploads/about/noimg.png') }}" alt="">
                            @endif
                        </div>
                        <div class="col-md-6 text-col ml-lg-auto">
                            <div class="repeat-text-box d-flex align-items-center flex-wrap">
                                <div class="repeat-wrap">
                                    <h3>{{ $commercial->name }}</h3>
                                    {!! Illuminate\Support\Str::limit($commercial->description, 300) !!}
                                    <a href="{{ route('page-view-details', $commercial->slug) }}"
                                        class="btn btn-primary mt-lg-4 mt-3">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
