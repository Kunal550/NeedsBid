@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Project | Admin')

@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }

    .img {
        height: 50px;
        width: 50px;
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
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Projects</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                        <li class="breadcrumb-item">Projects</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="projectDetails">
                        <thead>
                            <tr>
                                <th data-orderable="false">Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Budget</th>
                                <th>Bid Deadline</th>
                                <th class="text-center" data-orderable="false">Status</th>
                                <th class="text-center" data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $key => $project)
                            <tr>
                                <td class="text-center"><img src="{{ $project->avatar }}" class="img" alt=""></td>
                                <td>{{ ucwords($project->title) }}</td>
                                <td>{{ ucwords(optional($project->project_to_project_category)->name) }}</td>
                                <td>{{ ucwords($project->budget) }}</td>
                                <td>{{ $project->bid_deadline ? \Carbon\Carbon::parse($project->bid_deadline)->format('d-m-Y h:i:s A') : 'N/A' }}</td>


                                <td class="text-center"><span class="{{ $project->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $project->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($project->status == 'A')
                                    <a href="javascript:void(0);"
                                        onclick="changeStatus('{{ base64_encode($project->id) }}', 'projects', 'I')"
                                        title="Change to Inactive"><i
                                            class="text-success fas fa-toggle-on"></i></a>
                                    @else
                                    <a href="javascript:void(0);"
                                        onclick="changeStatus('{{ base64_encode($project->id) }}', 'projects', 'A')"
                                        title="Change to Active"><i
                                            class="text-danger fas fa-toggle-off"></i></a>
                                    @endif
                                    &nbsp;
                                    <a href="javascript:void(0);" onclick="edit('{{ base64_encode($project->id) }}')" title="Edit"><i class="fas fa-edit"></i></a>
                                    &nbsp;
                                    <a href="javascript:void(0);"
                                        onclick="delete_status('{{ base64_encode($project->id) }}', 'projects', 'D')"
                                        title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $projects->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pageModal" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pageModalLabel">Project Category <span id="modaltype">Info</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="$('#pageModal').modal('hide');">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.projects.project') }}" method="post" enctype="multipart/form-data" id="projectform">
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
                            <div class="col-md-2 oldimg">
                                <a href="" target="_blank"><img src="" class="img" id="editimg"
                                        alt="" style=" margin-top: 35%; "></a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rowid" id="rowid">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Add</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                        onclick="$('#pageModal').modal('hide');">Close</button>

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
        $('#projectDetails').dataTable({
            "bPaginate": false,
            "bInfo": false,
            dom: 'Bfrtip',
            buttons: [{
                text: '+ Add Project',
                attr: {
                    class: 'btn btn-success btn-sm'
                },
                action: function(e, dt, node, config) {
                    resetform();
                    $('#pageModal').modal('show');
                }
            }],
            'columnDefs': [{
                'targets': [2],
                'orderable': false,
            }]
        });
    });

    function edit(rowid) {
        let url = "{{ route('admin.projects.project-get') }}" + '/' + rowid;
        $.get(url, function(res) {
            if (res.code == '200') {
                resetform();
                putvalue(res.data);
                $('#pageModal').modal('show');
            }
        });
    }

    function resetform() {
        content.setData("");
        $('#pageModal').find('#name').val('');
        $('#pageModal').find('#project_category_name').val('');
        $('#pageModal').find('#price').val('');
        $('#pageModal').find('#project_deadline').val('');
        $('#pageModal').find('#rowid').val('');
        $("#pageModal").find("#editimg").attr("src", "");
        $("#pageModal").find("#editimg").parent("a").attr("href", "");
    }

    function putvalue(res) {
        $('#pageModal').find('#name').val(res.title);
        $('#pageModal').find('#project_category_name').val(res.project_to_project_category.name);
        $('#pageModal').find('#price').val(res.budget);
        $('#pageModal').find('#project_deadline').val(res.bid_deadline);


        if (res.description != null) {
            content.setData(res.description);
        }
        $(".oldimg").show();
        $("#pageModal").find("#editimg").attr("src", res.avatar);
        $("#pageModal").find("#editimg").parent("a").attr("href", res.avatar);
        $('#pageModal').find('#rowid').val(res.id);
    }

    function changeStatus(rowid, tbl, status) {
        $.confirm({
            title: 'Confirm!',
            content: 'Do you want to change the status?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                ok: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    action: function() {
                        $.ajax({
                            url: "{{ route('admin.status.change', ['type' => 'projects']) }}",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'rowid': rowid,
                                'status': status,
                                'tbl': tbl
                            },
                            type: 'POST',
                            success: function(res) {
                                if (res.code == '200') {
                                    toastr.success(res.msg);
                                    setTimeout(() => {
                                        location.reload();
                                    }, 3000);
                                }
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                },
                cancel: {
                    text: 'No',
                }
            }
        });
    }

    function delete_status(rowid, tbl, status) {
        $.confirm({
            title: "Are you sure?",
            content: "Do you want to Delete this?",
            type: "red",
            typeAnimated: true,
            buttons: {
                ok: {
                    text: "Yes",
                    btnClass: "btn-red",
                    action: function() {
                        $.ajax({
                            url: "{{ route('admin.delete_status', ['type' => 'projects']) }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                rowid: rowid,
                                status: status,
                                tbl: tbl,
                            },
                            type: "POST",
                            success: function(res) {
                                if (res.code == "200") {
                                    toastr.success(res.msg);
                                    setTimeout(() => {
                                        location.reload();
                                    }, 3000);
                                }
                            },
                            error: function(err) {
                                console.log(err);
                            },
                        });
                    },
                },
                cancel: {
                    text: "No",
                },
            },
        });
    }
    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>

<script>
    $(document).ready(function() {
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
@if (@$errors->has('project_err_rowid'))
@if (@$errors->has('project_err_rowid'))
<script>
    let rowid = "{{ @$errors->first('project_err_rowid') }}";
    edit(rowid);
</script>
@else
<script>
    $('#pageModal').modal('show');
</script>
@endif
@endif
@endpush