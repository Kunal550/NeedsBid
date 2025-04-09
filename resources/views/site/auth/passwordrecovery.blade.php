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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="shadow form-main">

                        <h2>Login</h2>
                        <form action="{{ route('password.recovery') }}" method="post" id="passwordrecoveryform">
                            @csrf
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="">
                                @if ($errors->has('password'))
                                    <span class="error"><small>{{ ucwords($errors->first('password')) }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="text" name="confirm_password" class="form-control" placeholder="">
                                @if ($errors->has('confirm_password'))
                                    <span
                                        class="error"><small>{{ ucwords($errors->first('confirm_password')) }}</small></span>
                                @endif
                            </div>
                            <input type="hidden" name="recovery_mail" value="{{ @$user->email }}">
                            <input type="hidden" name="rowid" value="{{ @$user->id }}">
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" onclick="loader('show');$('#passwordrecoveryform').submit();"
                                        class="btn btn-primary btn-block">Change password</button>
                                </div>
                            </div>
                        </form>
                        <!-- <p class="mt-3 mb-1">
                            <a href="{{ route('login_user') }}" onclick="gotologin()">Login</a>
                        </p> -->

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
            $("#forgotpasswordform")
                .formValidation({
                    message: "This value is not valid",
                    fields: {
                        forgot_mail: {
                            validators: {
                                notEmpty: {
                                    message: "The Forgot Mail Field Is Required.",
                                },
                            },
                        },
                    },

                });
        });

        function gotologin() {
            loader('show');
            setTimeout(() => {
                location.href = "{{ route('login_user') }}";
            }, 400);
        }
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
    </script>
@endpush
