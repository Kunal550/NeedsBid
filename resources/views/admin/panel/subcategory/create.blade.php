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

            <form class="needs-validation" novalidate action="{{ route('admin.subcategory.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="category" class="form-label">Select category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="" selected disabled>select category</option>
                            @foreach ($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Sub Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required value="{{ old('name') }}">
                    </div>
                    @if ($errors->has('name'))
                    <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection