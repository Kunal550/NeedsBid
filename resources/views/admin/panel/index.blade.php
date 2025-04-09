@extends('admin.panel.layout.sitelayout')
@section('mytitle', ' Dashboard | Admin')
@push('style')
<style>
    .error {
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
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>5</h3>
                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.users.list') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
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