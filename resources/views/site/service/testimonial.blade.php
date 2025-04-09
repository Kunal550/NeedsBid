@extends('site.layout.commonLayout')
@section('content')
    <section class="innerbanner">
        <div class="container">
            <div class="text-center innerbanner-text">
                <h2>Testimonial</h2>
                <div class="breadcrumb-box">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Testimonial</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="sec-space home-testimonial">
        <div class="container">
            
            <div class="owl-carousel tslider">
                @foreach ($testis as $teste)
                    <div class="item">
                        <div class="tbox">
                            <div class="tpara">
                                <p>{!! $teste->description !!}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <figure>
                                    <img src="{{ $teste->avatar }}"
                                        alt="">
                                </figure>
                                <div>
                                    <h3>{{ $teste->name }} <span>{{ $teste->designation }}</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
