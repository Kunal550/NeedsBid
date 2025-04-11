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

            <h2>Edit Profile</h2>

        </div>
        <div class="col-md-4 col-lg-3">
            <div class="left-bar">
                @include('site.auth.layout.sidebar')
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="right-main afrom-style">
                <form action="{{ route('account-details-update') }}" method="POST" enctype='multipart/form-data'
                    id="signupForm" class="row">
                    @csrf
                    <input type="hidden" name="account_id" value="{{ $profile->id }}">

                    <div class="form-group col-md-6">
                        <label for="profile_image">Profile Image</label>
                        <div class="d-flex align-items-center">
                            <div class="inputmain pr-2 img-input">
                                <input class="form-control" type="file" name="profile_image" id="profile_image"
                                    value="">
                            </div>
                            <div class="img-user">
                                <a href="#0" target="_blank">
                                    <img src="{{ $profile->avatar }}" class="img" id="editimg" alt="">
                                </a>
                            </div>
                        </div>
                        @if ($errors->has('profile_image'))
                        <span class="error"><small>{{ ucwords($errors->first('profile_image')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" value="{{ $profile->name }}"
                            name="name">
                        @if ($errors->has('name'))
                        <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="{{ $profile->email }}" class="form-control"
                            name="email" readonly>
                        @if ($errors->has('email'))
                        <span class="error"><small>{{ ucwords($errors->first('email')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone No.</label>
                        <input type="text" name="phone" id="phone" minlength="10" maxlength="12" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Enter your phone number" value="{{ $profile->phone }}" required>
                        @if ($errors->has('phone'))
                        <span class="error"><small>{{ ucwords($errors->first('phone')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="post_code">Post Code</label>
                        <input type="text" name="post_code" id="post_code" maxlength="7" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Enter your Post Code" value="{{ $profile->post_code }}" required>
                        @if ($errors->has('post_code'))
                        <span class="error"><small>{{ ucwords($errors->first('post_code')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <input type="address" id="address" class="form-control" name="address"
                            value="{{ $profile->address }}">
                        @if ($errors->has('address'))
                        <span class="error"><small>{{ ucwords($errors->first('address')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Company Info</label>
                        <textarea id="company_info" cols="30" rows="4" name="company_info" id="company_info" class="form-control">{!! $profile->company_info!!}</textarea>
                        @if ($errors->has('company_info'))
                        <span class="error"><small>{{ ucwords($errors->first('company_info')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Contact Details</label>
                        <textarea id="contact_details" cols="30" rows="4" name="contact_details" id="contact_details" class="form-control">{!! $profile->contact_details!!}</textarea>
                        @if ($errors->has('contact_details'))
                        <span class="error"><small>{{ ucwords($errors->first('contact_details')) }}</small></span>
                        @endif
                    </div>


                    <div class="form-group col-md-6">
                        <div class="form-group get-started-now">
                            <button type="submit" class="get-started-button"><span>Update Account</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection