@extends('site.layout.commonLayout')
@push('style')
    <style>
        .validation-error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
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
                <div class="col-md-8 col-lg-6">
                    <div class="shadow form-main">
                        <h2>Forgot Password</h2>
                        <form action="{{ route('forgot.password') }}" method="post" id="forgotpasswordform">
                            @csrf
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="forgot_mail" class="form-control" placeholder="Forgot Mail">
                                @error('forgot_mail')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Send Mail</button>
                                </div>
                            </div>
                        </form>
                        <!-- <button class="mt-3 mb-1 btn btn-info"><a href="{{ route('login_user') }}">Login</a></button> -->
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
            setTimeout(() => {
                $('.error').hide();
            }, 4500);
        </script>
    @endpush
