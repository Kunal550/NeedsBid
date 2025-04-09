@extends('site.layout.commonLayout')

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
                <h2>My Account</h2>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="left-bar">
                    @include('site.auth.layout.sidebar')
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="right-main">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Name</label>
                            <input type="text" class="form-control" readonly placeholder="{{ $profile->name }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email</label>
                            <input type="text" class="form-control" readonly placeholder="{{ $profile->email }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" readonly placeholder="{{ $profile->phone }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Address</label>
                            <input type="text" class="form-control" readonly placeholder="{{ $profile->address }}">
                        </div>
                    </div>
                    
                    <!-- <table class="table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $profile->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $profile->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $profile->phone }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $profile->address }}</td>
                            </tr>
                        </tbody>
                    </table> -->

                    <a href="{{ route('account-details') }}" class="btn btn-primary">Edit Details</a>
                </div>
            </div>
        </div>
    </div>

@endsection