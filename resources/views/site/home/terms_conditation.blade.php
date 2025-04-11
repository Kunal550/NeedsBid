@extends('site.layout.commonLayout')
@section('content')
<section class="innerbanner">
    <div class="container">
        <div class="text-center innerbanner-text">
            <h2>Terms & Conditation</h2>

            <div class="breadcrumb-box">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Terms & Conditation</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="sec-space">
    <div class="container">
        <div class="row">
            {!! $terms->description !!}
        </div>
    </div>
</section>
@endsection