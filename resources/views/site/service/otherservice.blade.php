@extends('site.layout.commonLayout')
@section('content')
<main>
    <!-- Banner -->
    <section class="no-overlay innerbanner"> 
        <figure class="innerbanner-img"><img src="{{asset('public/front_end/images/service-bg.jpg')}}" alt=""></figure> 
    </section>
    <!-- Other Services -->
    <section class="sec-space bg-gray other-ser-head">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 text-center">
                    <h2>Other Services</h2>
                    {!! $setting->other_ervices !!}
                </div>
            </div>
        </div>
    </section>

    <section class="service-repeat-sec">
        <!-- REPEATE SECTION -->
        @foreach ($otherservices as $otherservice)
        <div class="repeate-section position-relative">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-6 img-col">
                        <img src="{{asset('public/uploads/service/'.$otherservice->image)}}" alt="">
                    </div>
                    <div class="col-md-6 text-col ml-lg-auto"> 
                        <div class="repeat-text-box d-flex align-items-center flex-wrap">
                            <div class="repeat-wrap">
                                <h3>{{$otherservice->name}}</h3>
                                <p>{!!substr($otherservice->content,0,150)!!}..</p>
                                <a href="{{route('ServiceDetails',$otherservice->slug)}}" class="btn btn-primary mt-lg-4 mt-3">Explore Now</a>
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
                    <p>{!! $setting->have_question !!}</P>
                    <a href="{{route('contactus')}}" class="btn btn-white">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
</main>
</section>
@endsection