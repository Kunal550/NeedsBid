@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'About | Create | Admin')

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
                <form action="{{ route('admin.about.about-store') }}" method="post" enctype="multipart/form-data"
                    id="aboutform">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_id">Parent Name<span class="req">*</span></label>
                                <select name="parent_id" class="form-select parent_id" id="parent_id" required>
                                    <option value="">Select Parent</option>
                                    <option value="1">Stone Fabricators</option>
                                    <option value="2">Commercial</option>
                                    <option value="3">Residential</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name <span class="req">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="name">
                                @if ($errors->has('name'))
                                    <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Description</label>
                            <textarea name="content" id="content" class="form-control"></textarea>
                            @if ($errors->has('content'))
                                <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            @if ($errors->has('image'))
                                <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span>
                            @endif
                        </div>
                        <div class="col-md-2 oldimg">
                            <a href="" target="_blank"><img src="" class="img" id="editimg"
                                    alt="" style=" margin-top: 35%; "></a>
                        </div>
                    </div>

                    <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save &
                        Continue</button>
                    <a href="{{ route('admin.about.list') }}" type="button" class="btn btn-primary">Back</a>
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
            $("#aboutform")
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
                        parent_id: {
                            validators: {
                                notEmpty: {
                                    message: "Parent Name is required",
                                },
                            },
                        },

                    },
                })
        });
    </script>
@endpush
