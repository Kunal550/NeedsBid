@extends('site.layout.commonLayout')


@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }
</style>
@endpush
@section('content')
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

<section class="sec-space">
    <div class="login-bg">
        <div class="needs-bg-one">
            <div class="card card-bg1">
                <div class="card-body">
                    <div class="m-sm-3">
                        <div class="text-center wow bounceInRight">
                            <img src="{{ asset('public/front_end/images/login-logo.svg')}}" alt="" />
                        </div>
                        <h1 class=" text-center wow bounceInRight logo-heading-text">AS Project Owner</h1>
                        <form action="{{ route('Userlogin') }}" method="post" id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label wow bounceInRight">Email </label>
                                <input class="form-control form-control-lg" name="email" type="email" placeholder="Enter your email">
                                @if ($errors->has('email'))
                                <span class="error"><small>{{ ucwords($errors->first('email')) }}</small></span>
                                @endif

                            </div>
                            <div class="mb-3 position-relative">
                                <label class="form-label wow bounceInRight">Password</label>
                                <input class="form-control form-control-lg" name="password" type="password" placeholder="Enter your Password">
                                <button class="hide-icon" class="btn btn-outline-secondary" id="togglePassword"><i class="fas fa-eye"></i> </button>
                                @if ($errors->has('password'))
                                <span class="error"><small>{{ ucwords($errors->first('password')) }}</small></span>
                                @endif

                            </div>

                            <div class="text-center">
                                <button class="btn send-button-one btn-lg mt-3" onclick="loader('show');$('#loginForm').submit();">Login</button>
                            </div>
                            <div class="text-center need-our-text1">
                                New on our platform? <a href="{{ route('sign_up') }}">Create an account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const icon = $(this).find('i');

            // Toggle the password field type
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });

    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@endpush