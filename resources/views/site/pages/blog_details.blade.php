@extends('site.layout.commonLayout')
@section('content')
<section class="innerbanner">
    <div class="container">
        <div class="text-center innerbanner-text">
            <h2>{{$blog_details->name}}</h2>
            <div class="breadcrumb-box">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$blog_details->slug}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="sec-space">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="pbox">
                    <figure class="pimg"><img src="{{ asset('public/uploads/blog/' . $blog_details->blog_images) }}" alt=""></figure>
                </div>
            </div>
            <div class="col-md-6">
                <div class="pbox">
                    {!! $blog_details->description !!}

                </div>
            </div>
        </div>
    </div>
</section>
@endsection