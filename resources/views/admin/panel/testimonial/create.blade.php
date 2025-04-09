@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Testimonial | Create | Admin')
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
            <form action="{{ route('admin.cms.testimonial.store') }}" method="post" enctype="multipart/form-data" id="userForm">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Name<span class="req">*</span></label>
                                <input type="text" name="testimonial_name" id="testimonial_name" class="form-control"
                                    placeholder="Testimonial Title">
                                @if ($errors->has('testimonial_name'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('testimonial_name')) }}</small></span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="designation">Designation<span class="req">*</span></label>
                                <input type="text" name="designation" id="designation" class="form-control"
                                    placeholder="Enter Designation">
                                @if ($errors->has('designation'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('designation')) }}</small></span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="rating">Rating <span class="req">*</span></label>
                                <div id="rateYo" style="margin-bottom: 10px;"></div>
                                <input type="hidden" name="rating" id="rating" class="form-control">
                                @if($errors->has('rating')) <span class="error"><small>{{ ucwords($errors->first('rating')) }}</small></span> @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="testimonial_image">Image</label>
                                <input type="file" name="testimonial_image" id="testimonial_image" class="form-control"
                                    accept="image/*">
                                @if ($errors->has('testimonial_image'))
                                <span class="error"><small>{{ ucwords($errors->first('testimonial_image')) }}</small></span>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea name="testimonial_desc" id="testimonial_desc" class="form-control"></textarea>
                                @if ($errors->has('testimonial_desc'))
                                <span
                                    class="error"><small>{{ ucwords($errors->first('testimonial_desc')) }}</small></span>
                                @endif

                            </div>
                        </div>

                    </div>
                    <div class="pt-2">
                        <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                        <a href="{{ route('admin.cms.testimonial.list') }}" type="button" class="btn btn-primary">Back</a>
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
        ClassicEditor.create(document.querySelector('#testimonial_desc'))
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
                    testimonial_name: {
                        validators: {
                            notEmpty: {
                                message: "Testimonial name is required",
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
                    rating: {
                        validators: {
                            notEmpty: {
                                message: "Rating is required",
                            },
                        },
                    },

                },
            });


        $("#rateYo").rateYo({
            rating: 0,
            numStars: 5,
            precision: 1,
            halfStar: true,
            ratedFill: "#FFD700",
            fullStar: false
        }).on("rateyo.change", function(e, data) {
            $("#rating").val(data.rating.toFixed(1));
        });
        $("#rating").val(0);
    });
</script>
@endpush