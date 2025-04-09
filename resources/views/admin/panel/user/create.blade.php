@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'User | Create | Admin')
@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }

    small.help-block {
        color: red;
    }

    .img {
        height: 30px;
        width: 30px;
        border-radius: 50%;
    }

    .oldimg {
        display: none;
    }

    .select2-container {
        width: 100% !important;
        padding: 0;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src=" https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
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
<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <form action="{{ route('admin.users.user-store') }}" method="post" enctype="multipart/form-data" id="userForm">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Name<span class="req">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Name">
                                @if ($errors->has('name'))
                                <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="">Email<span class="req">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Email">
                                @if ($errors->has('email'))
                                <span class="error"><small>{{ ucwords($errors->first('email')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Password<span class="req">*</span></label>
                                <input type="password" name="new_password" minlength="6" maxlength="12" id="new_password" class="form-control"
                                    placeholder="Password">
                                <a class="i_icon" href="javascript:void(0);" onclick="NewPassword()"><i
                                        class="fa fa-eye"></i></a>
                                @if ($errors->has('new_password'))
                                <span class="error"><small>{{ ucwords($errors->first('new_password')) }}</small></span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="">Confirm Password<span class="req">*</span></label>
                                <input type="password" name="confirm_password" minlength="6" maxlength="12" id="confirm_password" class="form-control"
                                    placeholder="Confirm Password">
                                <a href="javascript:void(0);" class="i_icon" onclick="ConfirmPassword()">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if ($errors->has('confirm_password'))
                                <span class="error"><small>{{ ucwords($errors->first('confirm_password')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 form-group">
                                <label for="role">Roles <span class="req">*</span></label>
                                <select name="roles[]" class="form-select role" id="role" multiple required>
                                    <option value="">Select Roles</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ base64_encode($role['name']) }}">{{ $role['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="pt-2">
                        <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                        <a href="{{ route('admin.users.list') }}" type="button" class="btn btn-primary">Back</a>
                    </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function($) {

        "use strict";
        $("#userForm")
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
                                message: "Email Name is required",
                            },
                        },
                    },
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
                                message: "Confirm Password is required",
                            },
                            identical: {
                                field: "new_password",
                                message: "Passwords do not match",
                            },
                        },
                    },




                },
            });
    });

    function NewPassword() {
        var x = document.getElementById("new_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function ConfirmPassword() {
        var x = document.getElementById("confirm_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endpush