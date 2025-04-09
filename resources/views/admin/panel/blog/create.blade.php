@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Pages | Create | Admin')
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
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
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
            <form action="{{ route('admin.cms.blog.store') }}" method="post" enctype="multipart/form-data" id="userForm">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Name<span class="req">*</span></label>
                                <input type="text" name="blog_name" id="blog_name" class="form-control"
                                    placeholder="Blog Name">
                                @if ($errors->has('blog_name'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('blog_name')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control"
                                    accept="image/*">
                                @if ($errors->has('image'))
                                <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea name="blog_description" id="blog_description" class="form-control"></textarea>
                                @if ($errors->has('blog_description'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('blog_description')) }}</small></span>
                                @endif

                            </div>
                        </div>

                    </div>
                    <div class="pt-2">
                        <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                        <a href="{{ route('admin.cms.blog.list') }}" type="button" class="btn btn-primary">Back</a>
                    </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var content;
    $(function() {
        /** content */
        ClassicEditor.create(document.querySelector('#blog_description'))
            .then(editor => {
                content = editor;
                content.editing.view.change(writer => {
                    writer.setStyle('height', '200px', content.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error(error)
            });
    });
    $(document).ready(function($) {

        "use strict";
        $("#userForm")
            .formValidation({
                message: "This value is not valid",
                fields: {
                    blog_name: {
                        validators: {
                            notEmpty: {
                                message: "Blog Name is required",
                            },
                        },
                    },

                },
            });
    });
</script>
@endpush