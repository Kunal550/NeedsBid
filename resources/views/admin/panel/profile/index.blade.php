@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Profile | Admin')

@push('style')
    <style>
        .error {
            color: red;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <?php
    $errtype = 'profile-update';
    if (@$errors->has('err_type')) {
        $errtype = $errors->first('err_type');
    }
    ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $errtype == 'profile-update' ? 'active' : ''; ?>" id="custom-tabs-one-home-tab"
                                            data-toggle="pill" href="#custom-tabs-one-home" role="tab"
                                            aria-controls="custom-tabs-one-home" aria-selected="true">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $errtype == 'password-update' ? 'active' : ''; ?>" id="custom-tabs-one-profile-tab"
                                            data-toggle="pill" href="#custom-tabs-one-profile" role="tab"
                                            aria-controls="custom-tabs-one-profile" aria-selected="false">Password</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade <?php echo $errtype == 'profile-update' ? 'show active' : ''; ?>" id="custom-tabs-one-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-one-home-tab">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <form action="{{ route('admin.profilesetup') }}" method="post"
                                                    enctype="multipart/form-data" id="profileform">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="name">Name</label>
                                                            <input type="text" name="name" id="name"
                                                                class="form-control" placeholder="Admin Full Name"
                                                                value="{{ old('name', Auth::user()->name) }}">
                                                            @if ($errors->has('name'))
                                                                <span
                                                                    class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="email">Email-ID</label>
                                                            <input type="email" name="email" id="email" class="form-control" placeholder="Contact Email-ID." value="{{ old('email', Auth::user()->email) }}">
                                                            @if ($errors->has('email'))
                                                                <span class="error"><small>{{ ucwords($errors->first('email')) }}</small></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="phone">Phone No.</label>
                                                            <input type="text" name="phone" id="phone" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" placeholder="Contact No." value="{{ old('phone', Auth::user()->phone) }}">
                                                            @if ($errors->has('phone'))
                                                                <span class="error"><small>{{ ucwords($errors->first('phone')) }}</small></span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="profile_image">Profile Image</label>
                                                            <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
                                                            @if ($errors->has('profile_image'))
                                                                <span class="error"><small>{{ ucwords($errors->first('profile_image')) }}</small></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-primary" onclick="loader('show');$('#profileform').submit();">Update</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="type" value="profile-update">
                                                </form>
                                            </div>
                                            <div class="col-md-3">
                                                <img style="height:200px;width:200px;" src="{{ Auth::user()->avatar }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade <?php echo $errtype == 'password-update' ? 'show active' : ''; ?>" id="custom-tabs-one-profile"
                                        role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        <form action="{{ route('admin.profilesetup') }}" method="post" id="passwordform">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label for="old_password">Password</label>
                                                    <input type="password" name="old_password" id="old_password"
                                                        class="form-control" placeholder="Password">
                                                    @if ($errors->has('old_password'))
                                                        <span
                                                            class="error"><small>{{ ucwords($errors->first('old_password')) }}</small></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label for="new_password">New Password</label>
                                                    <input type="password" name="new_password" id="new_password"
                                                        class="form-control" placeholder="New Password">
                                                    @if ($errors->has('new_password'))
                                                        <span
                                                            class="error"><small>{{ ucwords($errors->first('new_password')) }}</small></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label for="confirm_password">Confirm Password</label>
                                                    <input type="password" name="confirm_password"
                                                        value="{{ old('confirm_password') }}" id="confirm_password"
                                                        class="form-control" placeholder="Confirm New Password">
                                                    @if ($errors->has('confirm_password'))
                                                        <span
                                                            class="error"><small>{{ ucwords($errors->first('confirm_password')) }}</small></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="hidden" name="type" value="password-update">
                                            <div class="row mt-3">
                                                <div class="col-md-7">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="loader('show');$('#passwordform').submit();">Update</button>
                                                </div>
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
@endsection
@push('script')
    <script>
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
    </script>
@endpush
