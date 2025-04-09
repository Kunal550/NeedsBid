@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Admin | Content|Create')
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
            <form action="{{ route('admin.content.content_store') }}" method="post" enctype="multipart/form-data"
                id="content-form">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Is Below Brand <span class="req">*</span></label>
                            <select name="is_below_brand" class="form-select is_below_brand" required>
                                <option value="">Choose a Page</option>
                                <option value="1">Is Below Brand</option>
                                <option value="2">Is Below Featured</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Title <span class="req">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Title">
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="button_name">Button Name <span class="req">*</span></label>
                            <input type="text" name="button_name" id="button_name" class="form-control"
                                placeholder="Button Name">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="button_link">Button Link <span class="req">*</span></label>
                            <input type="text" name="button_link" id="button_link" class="form-control"
                                placeholder="Button Link">
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="content_images">Content Image</label>
                            <input type="file" name="content_images" id="content_images" class="form-control"
                                accept="image/*">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="short_desc">Short Description</label>
                            <textarea id="" cols="30" rows="4" name="short_desc" id="short_desc" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                <a href="{{ route('admin.content.list') }}" type="button" class="btn btn-primary">Back</a>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        ClassicEditor.create(document.querySelector("#description"))
            .then((editor) => {
                content = editor;
                editor.editing.view.change(writer => {
                    writer.setStyle('height', '200px', editor.editing.view.document.getRoot());
                });
            })
            .catch((error) => {
                console.error(error);
            });

    });
    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@if (@$errors->has('content_err'))
@if (@$errors->has('content_err_rowid'))
<script>
    let rowid = "{{ @$errors->first('content_err_rowid') }}";
    edit(rowid);
</script>
@else
<script>
    $('#pageModal').modal('show');
</script>
@endif
@endif

<script>
    $(document).ready(function($) {
        "use strict";
        $("#content-form")
            .formValidation({
                message: "This value is not valid",
                fields: {
                    is_below_brand: {
                        validators: {
                            notEmpty: {
                                message: "Is Below is required",
                            },
                        },
                    },
                    title: {
                        validators: {
                            notEmpty: {
                                message: "Title is required",
                            },
                        },
                    },
                    button_name: {
                        validators: {
                            notEmpty: {
                                message: "Button Name is required",
                            },
                        },
                    },
                    button_link: {
                        validators: {
                            notEmpty: {
                                message: "Button Link is required",
                            },
                        },
                    },

                },
            })
    });
</script>
@endpush