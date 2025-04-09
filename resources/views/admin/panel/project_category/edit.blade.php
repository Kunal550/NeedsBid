@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Project Category | Edit | Admin')
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
            <form action="{{ route('admin.project-category.update') }}" method="post" enctype="multipart/form-data" id="projectform">
                @csrf
                <input type="hidden" name="cat_id" id="cat_id" value="{{ base64_encode($category->id) }}">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" placeholder="name">
                                    @if ($errors->has('name'))
                                    <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="content">Description</label>
                                <textarea name="content" id="content" class="form-control" value="{{ $category->content }}">{!! $category->content !!}</textarea>
                                @if ($errors->has('content'))
                                <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <a href="{{ URL::to('public/uploads/project_category/' . $category->image) }}" class="image-showbanner" target="_blank"> <img src="{{ URL::to('public/uploads/project_category/' . $category->image) }}" class="img" id="editimg" alt=""></a>
                                @if ($errors->has('image'))
                                <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="rowid" id="rowid">
                    </div>
                    <div class="pt-2">
                        <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                        <a href="{{ route('admin.project-category.list') }}" type="button" class="btn btn-primary">Back</a>
                    </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function($) {
        ClassicEditor.create(document.querySelector("#content"))
            .then((editor) => {
                content = editor;
                editor.editing.view.change(writer => {
                    writer.setStyle('height', '200px', editor.editing.view.document.getRoot());
                });
            })
            .catch((error) => {
                console.error(error);
            });
        "use strict";
        $("#projectform")
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

                },
            });
    });
</script>
@endpush