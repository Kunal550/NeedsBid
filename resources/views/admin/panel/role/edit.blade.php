@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Permission | Edit | Admin')

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

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Role</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.roles.list') }}"
                            class="btn btn-sm btn-dark">Back</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.roles.role-store') }}" method="POST"
                    class="needs-validation" novalidate="">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        required="" value="{{ $data->name }}">
                                    @if ($errors->has('name'))
                                    <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer float-end float-right">
                        <button type="submit" id="submit"
                            class="btn btn-primary float-end float-right">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection