@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Page | Edit | Admin')

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            <form action="{{ route('admin.cms.how_it_work.update') }}" method="post" enctype="multipart/form-data" id="userForm">
                @csrf
                <input type="hidden" name="work_id" id="work_id" value="{{ base64_encode($data->id) }}">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Name<span class="req">*</span></label>
                                <input type="text" name="how_it_work" id="how_it_work" class="form-control" value="{{ $data->name }}" placeholder="How It Work Title">
                                @if ($errors->has('how_it_work'))
                                <span class="error"><small>{{ ucwords($errors->first('how_it_work')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="page_desc">Description</label>
                                <textarea name="page_desc" id="page_desc" class="form-control" value="{{ $data->description }}">{{ strip_tags($data->description) }}</textarea>
                                @if ($errors->has('page_desc'))
                                <span class="error"><small>{{ ucwords($errors->first('page_desc')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="image">Image</label>
                                <input type="file" name="how_it_work_image" id="how_it_work_image" class="form-control" accept="image/*">
                                <a href="{{ URL::to('public/uploads/how_it_work/' . $data->how_it_work_image) }}" class="image-showbanner" target="_blank"> <img src="{{ URL::to('public/uploads/how_it_work/' . $data->how_it_work_image) }}" class="img" id="editimg" alt=""></a>
                            </div>

                        </div>


                    </div>
                    <div class="pt-2">
                        <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                        <a href="{{ route('admin.cms.pages.list') }}" type="button" class="btn btn-primary">Back</a>
                    </div>

            </form>
        </div>
    </div>
</div>
@endsection