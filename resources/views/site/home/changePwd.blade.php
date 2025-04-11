@extends('site.layout.commonLayout')
@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }

    .img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
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
<div class="container emp-profile">

    <div class="row">
        <div class="col-md-12">
            <h2>Edit Password</h2>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="left-bar">
                @include('site.auth.layout.sidebar')
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="right-main">
                <form action="{{ route('update-password') }}" method="POST" enctype='multipart/form-data' id="signupForm"
                    class="row">
                    @csrf
                    <input type="hidden" name="account_id" value="{{ $profile->id }}">

                    <div class="form-group col-md-6">
                        <label for="password">New Password</label>
                        <div class="inputmain">
                            <input type="password" id="new_password" minlength="6" maxlength="15" class="form-control"
                                name="new_password">
                            <button type="button" class="hide-icon btn btn-outline-secondary" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>

                        </div>
                        @if ($errors->has('new_password'))
                        <span class="error"><small>{{ ucwords($errors->first('new_password')) }}</small></span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="inputmain">
                            <input type="password" id="confirm_password" minlength="6" maxlength="15"
                                class="form-control" name="confirm_password">
                            <button type="button" class="hide-icon btn btn-outline-secondary" id="togglePassword1">
                                <i class="fas fa-eye"></i>
                            </button>

                        </div>
                        @if ($errors->has('confirm_password'))
                        <span class="error"><small>{{ ucwords($errors->first('confirm_password')) }}</small></span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        "use strict";
        $("#signupForm")
            .formValidation({
                message: "This value is not valid",
                fields: {
                    new_password: {
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
                                field: "new_password",
                                message: "Confirm password is not matching, please re-confirm the password",
                            },
                        },
                    }
                },

            });
    });


    $('#togglePassword').on('click', function() {
        const passwordField = $('#new_password');
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

    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@endpush