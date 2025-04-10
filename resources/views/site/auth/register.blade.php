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
<section class="sec-space">
    <div class="login-bg" style='margin-top:-100px;'>
        <div class="container">
            <div class="needs-bg-one">
                <div class="card card-bg1">
                    <div class="needs-bg-one">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="shadow form-main">
                                            <h2 class="text-center wow bounceInRight register-heading-text">Register</h2>
                                            <form action="{{ route('register.post') }}" method="POST" enctype='multipart/form-data' id="signupForm">
                                                @csrf

                                                <div class="row">

                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="name" class="form-label">Name <span class="req">*</span></label>
                                                            <input type="text" id="name" class="form-control" name="name" placeholder="Name">
                                                            @if ($errors->has('name'))
                                                            <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email" class="form-label">Email <span class="req">*</span></label>
                                                            <input type="email" id="email" class="form-control" name="email"
                                                                placeholder="Email">
                                                            @if ($errors->has('email'))
                                                            <span class="error"><small>{{ ucwords($errors->first('email')) }}</small></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="phone" class="form-label">Phone No. <span class="req">*</span></label>
                                                            <input type="text" name="phone" id="phone" minlength="10" maxlength="12"
                                                                class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                                placeholder="Enter your phone number" required>
                                                            @if ($errors->has('phone'))
                                                            <span class="error"><small>{{ ucwords($errors->first('phone')) }}</small></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="password" class="form-label">Password <span class="req">*</span></label>
                                                            <input type="password" id="password" minlength="6" maxlength="16" class="form-control"
                                                                name="password">
                                                            <button type="button" class="hide-icon btn btn-outline-secondary" id="togglePassword">
                                                                <i class="fas fa-eye"></i>
                                                            </button>


                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="confirm_password" class="form-label">Confirm Password <span class="req">*</span></label>
                                                            <input type="password" id="confirm_password" minlength="6" maxlength="15"
                                                                class="form-control" name="confirm_password">

                                                            <button type="button" class="hide-icon btn btn-outline-secondary" id="togglePassword1">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            @if ($errors->has('confirm_password'))
                                                            <span
                                                                class="error"><small>{{ ucwords($errors->first('confirm_password')) }}</small></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="confirm_password" class="form-label">Captcha<span class="req">*</span></label>
                                                                    <div class="captcha d-flex mb-3">
                                                                        <span class="cp-img">{!! captcha_img('math') !!}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="confirm_password" class="form-label w-100">&nbsp;<span class="req"></span></label>

                                                                    <button type="button" class="btn btn-success btn-refresh">
                                                                        <i class="fa fa-refresh"></i></button>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="confirm_password" class="form-label">&nbsp;<span class="req"></span></label>

                                                        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                                            name="captcha">
                                                        @if ($errors->has('captcha'))
                                                        <span class="error"><small>{{ ucwords($errors->first('captcha')) }}</small></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary w-100">Register</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        "use strict";
        $("#signupForm")
            .formValidation({
                message: "This value is not valid",
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: "Name is required",
                            },
                        },
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: "Email is required",
                            },
                        },
                    },

                    password: {
                        validators: {
                            notEmpty: {
                                message: "Password is required",
                            },
                        },
                    },
                    confirm_password: {
                        validators: {
                            notEmpty: {
                                message: "Confirm Password is required\n",
                            },
                            identical: {
                                field: "password",
                                message: "Confirm password is not matching, please re-confirm the password",
                            },
                        },
                    },

                    phone: {
                        validators: {
                            notEmpty: {
                                message: "Phone Number is required",
                            },
                        },
                    },

                    captcha: {
                        validators: {
                            notEmpty: {
                                message: "Captcha is required",
                            },
                        },
                    },

                },

            });
    }).on("success.form.fv", function(e) {
        e.preventDefault();
        var formData = new FormData($('#signupForm')[0]);
        $.ajax({
            url: "{{ route('register.post') }}",
            processData: false,
            contentType: false,
            type: "post",
            data: formData,
            success: function(res) {
                if (res.status == '1') {
                    toastr.success(res.msg);
                    setTimeout(() => {
                        location.href = "{{ route('login_user') }}";
                    }, 2000);
                } else {
                    toastr.error(res.msg);
                }
            },
            error: function(err) {
                console.log(err);
            }
        });


    });

    $('#togglePassword').on('click', function() {
        const passwordField = $('#password');
        const icon = $(this).find('i');

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#togglePassword1').on('click', function() {
        const passwordField = $('#confirm_password');
        const icon = $(this).find('i');

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $(".btn-refresh").click(function() {
        $.ajax({
            type: 'GET',
            url: "{{ route('refresh_captcha') }}",
            success: function(data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@endpush