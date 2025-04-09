@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Project | Create | Admin')
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
            <form action="{{ route('admin.projects.project-store') }}" method="post" enctype="multipart/form-data" id="projectform">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="name">
                                    @if ($errors->has('name'))
                                    <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="project_category_name">Project Category <span class="req">*</span></label>
                                <select name="project_category_name" class="form-select projects" id="project_category_name">
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
                            <div class="col-md-4">
                                <label for="contractor_trade">Contractor Trade <span class="req">*</span></label>
                                <select name="contractor_trade" class="form-select contractor_trade" id="contractor_trade">
                                    <option value="">Select Contractor Trade</option>
                                    @foreach ($contractors as $contractor)
                                    <option value="{{ base64_encode($contractor->id) }}"> {{ $contractor->name }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('contractor_trade'))
                                <span class="error"><small>{{ ucwords($errors->first('contractor_trade')) }}</small></span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label for="constructor_type">Constructor Type <span class="req">*</span></label>
                                <select name="constructor_type" class="form-select constructor_type" id="constructor_type">
                                    <option value="">Select Constructor Type</option>
                                    @foreach ($constructors as $constructor)
                                    <option value="{{ base64_encode($constructor->id) }}"> {{ $constructor->name }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('constructor_type'))
                                <span class="error"><small>{{ ucwords($errors->first('constructor_type')) }}</small></span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="states">States <span class="req">*</span></label>
                                <select name="states" class="form-select states" id="states">
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
                            <div class="col-md-6">
                                <label for="price">Price <span class="req">*</span></label>
                                <input type="text" name="price" id="price" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Enter Price">
                                @if ($errors->has('price'))
                                <span class="error"><small>{{ ucwords($errors->first('price')) }}</small></span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="project_deadline">Project Deadline <span class="req">*</span></label>
                                <input type="date" name="project_deadline" id="project_deadline" class="form-control" placeholder="Enter Date">
                                @if ($errors->has('project_deadline'))
                                <span class="error"><small>{{ ucwords($errors->first('project_deadline')) }}</small></span>
                                @endif
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-md-12">
                                <label for="content">Project Description</label>
                                <textarea name="content" id="content" class="form-control"></textarea>
                                @if ($errors->has('content'))
                                <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                @if ($errors->has('image'))
                                <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="other_file">Other File</label>
                                <input type="file" name="other_file" id="other_file" class="form-control" accept=".pdf,.doc,.docx">
                                @if ($errors->has('other_file'))
                                <span class="error"><small>{{ ucwords($errors->first('other_file')) }}</small></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rowid" id="rowid">
                </div>
                <div class="pt-2">
                    <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save & Continue</button>
                    <a href="{{ route('admin.projects.project') }}" type="button" class="btn btn-primary">Back</a>
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