<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('public/front_end/images/favicon.png')}}" type="image/x-icon">
    <title>Needs Bids</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <!------------------- 
        Bootstrap-4 
        Owl-carousel 
        Fancybox 
        Animate
        Fontawesome 
        Style 
        Responsive 
    -------------------->
    <link rel="stylesheet" href="{{asset('public/front_end/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/front_end/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/front_end/css/fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('public/front_end/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/front_end/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/front_end/css/responsive.css')}}">
</head>

<body>
    <main>
        <!-- Scroll To Top Button -->
        <div class="go-top go-top-button active">
            <i class="fa fa-long-arrow-up"></i>
            <i class="fa fa-long-arrow-up"></i>
        </div>
        <!-- Rating -->
        <a href="#" class="rating-link d-inline-flex align-items-center" target="_blank">
            <figure class="mr-2"><img src="{{asset('public/front_end/images/google-rating.png')}}" alt=""></figure>
            <p>
                <span class="d-block mb-1">Google Rating</span>
                <em class="d-inline-flex align-items-center">5.0 <img class="ml-1" src="{{asset('public/front_end/images/star.png')}}" alt=""><img src="{{asset('public/front_end/images/star.png')}}" alt=""><img src="{{asset('public/front_end/images/star.png')}}" alt=""><img src="{{asset('public/front_end/images/star.png')}}" alt=""><img src="{{asset('public/front_end/images/star.png')}}" alt=""></em>
            </p>
        </a>

        <!-- HEADER -->
        @include('site.layout.header')

        @yield('content');
        <!-- FOOTER -->
        @include('site.layout.footer')
    </main>
    <script src="{{asset('public/front_end/js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('public/front_end/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/front_end/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('public/front_end/js/sticky-sidebar.js')}}"></script>
    <script src="{{asset('public/front_end/js/fancybox.js')}}"></script>
    <script src="{{asset('public/front_end/js/custom.js')}}"></script>
</body>
@yield('script')

</html>