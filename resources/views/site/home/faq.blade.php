@extends('site.layout.commonLayout')
@section('content')
<section class="innerbanner">
    <div class="container">
        <div class="text-center innerbanner-text">
            <h2>FAQ's</h2>

            <div class="breadcrumb-box">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ's</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- FAQS -->
<section class="sec-space faq-sec pt-md-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-10">
                <div id="faqs" class="myaccordion">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($datas as $data)
                    @php
                    $i = $i+1;
                    @endphp
                    <div class="faq-card">
                        <button class="d-flex align-items-center justify-content-between faq-link collapsed"
                            data-toggle="collapse" data-target="#faq{{ $data->id }}" aria-expanded="{{ $i == 1 ? 'true' : 'false' }}" aria-controls="faq{{ $data->id }}">
                            {{ $data->question }}
                            <span>
                                <i class="fa fa-plus"></i>
                            </span>
                        </button>
                        <div id="faq{{ $data->id }}" class="collapse {{ $i == 1 ? 'show' : '' }}"
                            aria-labelledby="heading{{ $data->id }}" data-parent="#faqs">
                            <div class="faq-body">
                                <p>{!! $data->answer !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection