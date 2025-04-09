<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('mytitle') | {{ env('APP_NAME') }}</title>
    
    <link rel="shortcut icon" href="{{ asset('public/front_end/images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('public/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('public/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/dist/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    
    <script src="{{ asset('public/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    
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
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div id="myDiv">
        <img style="height:180px;" src="https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/bc0c6b69321565.5b7d0cbe723b5.gif" alt="AdminLTELogo">
    </div>
    <div class="wrapper">
        @include('admin.panel.layout.src.navbar')
        @include('admin.panel.layout.src.sidebar')
        @yield('content')
        @include('admin.panel.layout.src.rightsidebar')
        
        <footer class="main-footer mt-2">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://businessprodigital.com/" target="_blank">Business Pro Digital PVT. LTD.</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('public/admin/dist/js/demo.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <script src="{{ asset('public/admin/dist/js/formValidation.js') }}"></script>
    <script src="{{ asset('public/admin/dist/js/bootstrap-validation.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('#myDiv').hide();
            $('[data-toggle="tooltip"]').tooltip();

            // Initialize Chart only if canvas element exists
            var ctx = document.getElementById('myChart'); 
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {/* chart data */},
                    options: {/* chart options */}
                });
            }
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
    @if (Session::has('message-success'))
        <script>
            toastr.success("{{ Session::get('message-success') }}");
        </script>
    @endif

    @if (Session::has('message-error'))
        <script>
            toastr.error("{{ Session::get('message-error') }}");
        </script>
    @endif
</body>

</html>
