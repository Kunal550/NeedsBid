<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000" />
    <title>Needs Bids</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('public/front_end/images/favicon.ico') }}" type="image/x-icon">

    <!-- Google Font -->
    <link rel="preconnect" href="//fonts.googleapis.com">
    <link rel="preconnect" href="//fonts.gstatic.com" crossorigin>
    <link href="//fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap & Core Styles -->
    <link rel="stylesheet" href="{{ asset('public/front_end/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/front_end/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/front_end/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/front_end/css/fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('public/front_end/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/dist/css/custom.css') }}">

    <!-- jQuery (Must be loaded before other scripts) -->
    <script src="{{ asset('public/front_end/js/jquery-3.4.1.min.js') }}"></script>

    <!-- External CSS (Plugins) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    <!-- ShareThis API -->
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=64f6d6c60352c00019d16921&product=sop' async></script>

    @stack('style')

    <style>
        #myDiv {
            position: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0.7;
            background-color: #fff;
            z-index: 9999;
        }
        .st-custom-button[data-network] {
            background-color: #0ADEFF;
            display: inline-block;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
        }
        .st-custom-button[data-network]:hover,
        .st-custom-button[data-network]:focus {
            text-decoration: none;
            background-color: #00C7FF;
        }
    </style>
</head>

<body>
    <main>
        <div id="myDiv">
            <img style="height:180px;" src="//mir-s3-cdn-cf.behance.net/project_modules/max_1200/bc0c6b69321565.5b7d0cbe723b5.gif" alt="AdminLTELogo">
        </div>

        <!-- Scroll To Top Button -->
        <div class="go-top go-top-button active d-none">
            <i class="fa fa-long-arrow-up"></i>
            <i class="fa fa-long-arrow-up"></i>
        </div>

        <!-- HEADER -->
        @include('site.layout.header')
        @yield('content')
        <!-- FOOTER -->
        @include('site.layout.footer')

    </main>

    <!-- Bootstrap & JS Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="{{ asset('public/front_end/js/bootstrap.min.js') }}"></script>

    <!-- Plugin Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('public/front_end/js/wow.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-appear/0.1/jquery.appear.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('public/front_end/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/front_end/js/sticky-sidebar.js') }}"></script>
    <script src="{{ asset('public/front_end/js/fancybox.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-one-page-nav/3.0.0/jquery.nav.min.js"></script>

    <!-- BxSlider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js"></script>

    <!-- RateYo (Star Ratings) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <!-- Form Validation -->
    <script src="{{ asset('public/admin/dist/js/formValidation.js') }}"></script>
    <script src="{{ asset('public/admin/dist/js/bootstrap-validation.js') }}"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('public/front_end/js/custom.js') }}"></script>
    <script src="{{ asset('public/front_end/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#myDiv').hide();
            $('[data-toggle="tooltip"]').tooltip();
        });

        function loader(loadtype) {
            if (loadtype == 'show') {
                $('#myDiv').show();
            } else {
                $('#myDiv').hide();
            }
        }
    </script>

    @stack('script')

</body>
</html>
