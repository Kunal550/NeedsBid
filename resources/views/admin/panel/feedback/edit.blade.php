@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Feedback | Edit | Admin')
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
            <form action="{{ route('admin.cms.feedback.update') }}" method="post" enctype="multipart/form-data" id="userForm">
                @csrf
                <input type="hidden" name="feedback_id" id="feedback_id" value="{{ base64_encode($data->id) }}">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name<span class="req">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $data->name }}" placeholder="Name">
                                @if ($errors->has('name'))
                                <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="designation">Designation<span class="req">*</span></label>
                                <input type="text" name="designation" id="designation" value="{{ $data->name }}" class="form-control"
                                    placeholder="Designation">
                                @if ($errors->has('designation'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('designation')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <label for="client_image">Image</label>
                                <input type="file" name="client_image" id="client_image" class="form-control"
                                    accept="image/*" />
                                    <a href="{{ URL::to('public/uploads/client_images/' . $data->client_image) }}" class="image-showbanner" target="_blank"> <img src="{{ URL::to('public/uploads/client_images/' . $data->client_image) }}" class="img" id="editimg" alt=""></a>
                                @if ($errors->has('client_image'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('client_image')) }}</small></span>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea name="client_desc" id="client_desc" class="form-control" value="{{ $data->content }}">{!! $data->content !!}</textarea>
                                @if ($errors->has('client_desc'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('client_desc')) }}</small></span>
                                @endif

                            </div>
                        </div>

                    </div>
                    <div class="pt-2">
                        <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                        <a href="{{ route('admin.cms.feedback.list') }}" type="button" class="btn btn-primary">Back</a>
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
        ClassicEditor.create(document.querySelector('#client_desc'))
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
                    name: {
                        validators: {
                            notEmpty: {
                                message: "Name is required",
                            },
                        },
                    },
                    designation: {
                        validators: {
                            notEmpty: {
                                message: "Designation is required",
                            },
                        },
                    },

                },
            });
    });
</script>
@endpush