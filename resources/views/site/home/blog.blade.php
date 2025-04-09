@extends('site.layout.commonLayout')
@section('content')
    <section class="innerbanner">
        <div class="container">
            <div class="text-center innerbanner-text">
                <h2>Blog</h2>
                <div class="breadcrumb-box">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="home-blog sec-space">
        <div class="container">
            <h2>Featured Blog</h2>
            <div class="owl-carousel blog-slider">
                @foreach ($blogs as $blog)
                    @php
                        $date = $blog->created_at;
                        $toDate = date_format($date, 'd M Y');
                    @endphp

                    <div class="item">
                        <a href="{{route('blog-details',$blog->slug)}}" class="blog-box">
                            <figure class="bimg">
                                <img src="{{ $blog->avatar }}" alt="">
                            </figure>
                            <div class="bcontent">
                                <div class="bdate">
                                    <strong>{{ $toDate }} </strong>
                                </div>
                                <h3>{!! $blog->description !!}</h3>
                                <a href="{{route('blog-details',$blog->slug)}}" class="readmore-btn">Read More</a>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
