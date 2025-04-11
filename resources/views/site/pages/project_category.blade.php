@extends('site.layout.commonLayout')
@section('content')
<section class="innerbanner">
    <div class="container">
        <div class="text-center innerbanner-text">
            <h2>{{$project_details->name}}</h2>
            <div class="breadcrumb-box">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$project_details->slug}}</li>
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
                    <figure class="pimg"><img src="{{ $project_details->avatar }}" alt=""></figure>
                </div>
            </div>
            <div class="col-md-6">
                <div class="pbox">
                    {!! $project_details->content !!}

                </div>
            </div>
        </div>
    </div>
</section>
@endsection