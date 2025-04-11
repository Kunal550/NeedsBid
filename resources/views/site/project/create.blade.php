@extends('site.layout.commonLayout')
@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }

    .img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src=" https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
<script src="{{ asset('public/admin/dist/js/formValidation.js') }}"></script>
    <script src="{{ asset('public/admin/dist/js/bootstrap-validation.js') }}"></script>
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
<div class="container emp-profile">

    <div class="row">
        <div class="col-md-12">
            <h2>Job Create</h2>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="left-bar">
                @include('site.auth.layout.sidebar')
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="right-main  afrom-style">
                <form action="{{ route('project.store') }}" method="post" enctype="multipart/form-data" id="projectform">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Name<span class="req">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="name">
                            @if ($errors->has('name'))
                            <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Project Category <span class="req">*</span></label>
                            <select name="project_category_name" class="form-control projects" id="project_category_name">
                                <option value="">Select Category</option>
                                @foreach ($project_categories as $project_category)
                                <option value="{{ base64_encode($project_category->id) }}"> {{ $project_category->name }} </option>
                                @endforeach
                            </select>
                            @if ($errors->has('project_category_name'))
                            <span class="error"><small>{{ ucwords($errors->first('project_category_name')) }}</small></span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="contractor_trade">Contractor Trade <span class="req">*</span></label>
                            <select class="form-control" name="contractor_trade" id="contractor">
                                @foreach ($contractors as $contractor)
                                <option value="{{ base64_encode($contractor->id) }}"> {{ $contractor->name }} </option>
                                @endforeach
                            </select>
                            @if ($errors->has('contractor_trade'))
                            <span class="error"><small>{{ ucwords($errors->first('contractor_trade')) }}</small></span>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="constructorType">Constructor Type <span class="req">*</span></label>
                            <select class="form-control" id="constructorType">
                                <option value="">Select Constructor Type</option>
                                @foreach ($constructors as $constructor)
                                <option value="{{ base64_encode($constructor->id) }}"> {{ $constructor->name }} </option>
                                @endforeach
                            </select>
                            @if ($errors->has('constructor_type'))
                            <span class="error"><small>{{ ucwords($errors->first('constructor_type')) }}</small></span>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">States <span class="req">*</span></label>
                            <select class="form-control" id="state">
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                <option value="{{ base64_encode($state->id) }}"> {{ $state->name }} </option>
                                @endforeach
                            </select>
                            @if ($errors->has('states'))
                            <span class="error"><small>{{ ucwords($errors->first('states')) }}</small></span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="price">Price <span class="req">*</span></label>
                            <input type="text" name="price" id="price" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="price" placeholder="Enter Price">
                            @if ($errors->has('price'))
                            <span class="error"><small>{{ ucwords($errors->first('price')) }}</small></span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="deadline">Project Deadline <span class="req">*</span></label>
                            <input type="date" class="form-control" name="project_deadline" id="project_deadline" placeholder="dd-mm-yyyy">
                            @if ($errors->has('project_deadline'))
                            <span class="error"><small>{{ ucwords($errors->first('project_deadline')) }}</small></span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Project Description</label>
                        <textarea class="form-control" name="content" id="content"></textarea>
                        @if ($errors->has('content'))
                        <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span>
                        @endif
                    </div>
                    <div class=" row">

                        <div class="form-group col-sm-6 img-input">
                            <label for="imageFile">Image (JPG/PNG)</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            @if ($errors->has('image'))
                            <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span>
                            @endif
                        </div>

                        <div class="form-group col-sm-6 img-input">
                            <label for="otherFile">Other File (DOCX/PDF)</label>
                            <input type="file" class="form-control" name="other_file" id="other_file" accept=".docx,.pdf">
                            @if ($errors->has('other_file'))
                            <span class="error"><small>{{ ucwords($errors->first('other_file')) }}</small></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group get-started-now">
                            <button type="submit" name="btn_type" value="continue" class="get-started-button"><span>Save & Continue</span></button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

                    project_category_name: {
                        validators: {
                            notEmpty: {
                                message: "Category Name is required",
                            },
                        },
                    },

                    contractor_trade: {
                        validators: {
                            notEmpty: {
                                message: "Contractor Trade is required",
                            },
                        },
                    },
                    constructor_type: {
                        validators: {
                            notEmpty: {
                                message: "Constructor Type is required",
                            },
                        },
                    },
                    states: {
                        validators: {
                            notEmpty: {
                                message: "State is required",
                            },
                        },
                    },
                    price: {
                        validators: {
                            notEmpty: {
                                message: "Price Name is required",
                            },
                        },
                    },
                    project_deadline: {
                        validators: {
                            notEmpty: {
                                message: "Project Deadline is required",
                            },
                        },
                    },

                },
            });
    });
</script>
@endpush