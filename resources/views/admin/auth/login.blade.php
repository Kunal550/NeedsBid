@extends('admin.auth.layout.authlayout')
<!-- @section('page_title', 'Log in') -->
@section('mytitle', 'Log in | Admin')
@push('head_script')
@endpush
@section('auth')
    <style>
        .error {
            color: red;
        }
    </style>
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}")
        </script>
    @endif
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif
    @php
        $setting = App\Models\Setting::first();
    @endphp
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ route('admin.login') }}" class="h1"><img
                    src="{{ asset('public/uploads/setting/' . optional($setting)->logo) }}" alt="logo"></a>
        </div>
        <div class="card-body">
            <ul>
                @if ($errors->has('email'))
                    <li class="error"><span class="text-left"><small>{{ ucwords($errors->first('email')) }}</small></span>
                    </li>
                @endif
                @if ($errors->has('password'))
                    <li class="error">
                        <span><small>{{ ucwords($errors->first('password')) }}</small></span>
                    </li>
                @endif
                @if ($errors->has('captcha'))
                    <li class="error">
                        <span><small>{{ ucwords($errors->first('captcha')) }}</small></span>
                    </li>
                @endif
            </ul>
            <form action="{{ route('admin.login') }}" method="post" id="loginform">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="captcha d-flex">
                        <span>{!! captcha_img('math') !!}</span>
                        
                        <button type="button" class="btn btn-success btn-refresh mx-1"> <!-- <i class="fas fa-refresh"></i> --> Reset</button>

                        <input id="captcha" type="text" class="form-control mr-1" placeholder="Enter Captcha" name="captcha">
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="rememberme" id="remember" value="on">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="button" onclick="loader('show');$('#loginform').submit();"
                            class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
            <p class="mb-1">
                <a href="javascript:void(0);" onclick="forgotbtn()">I forgot my password</a>
            </p>
        </div>
    </div>
    <script>
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
        $(".btn-refresh").click(function() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.refresh_captcha') }}",
                    success: function(data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
        function forgotbtn() {
            loader('show');
            setTimeout(() => {
                location.href = "{{ route('admin.forgot.password') }}";
            }, 400);
        }
    </script>
@endsection
