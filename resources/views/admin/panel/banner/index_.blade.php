@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Admin | Banner')
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

        .morecontent span {
            display: none;
        }

        .ReadMore {
            display: visible;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />
    @endpush @section('content')
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
        @endif @if (session('success'))
            <script>
                toastr.success("{{ session('success') }}");
            </script>
        @endif
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Banner</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.login') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item">Banner</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row table-resposive">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="bannertbl">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        {{-- <th>Content</th> --}}
                                        <th class="text-center">Status</th>
                                        <th class="text-center" data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banner as $b)
                                        <tr>
                                            <td class="text-center">
                                                <img src="{{ $b->avatar }}" class="img" alt="" />
                                            </td>
                                            <td>{{ $b->title }}</td>
                                            {{-- <td class="showReadMore">
                                                {!! $b->content !!}
                                            </td> --}}
                                            <td class="text-center">
                                                <span
                                                    class="{{ $b->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $b->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                            </td>

                                            <td class="text-center">
                                                @if ($b->status == 'A')
                                                    <a href="javascript:void(0);"
                                                        onclick="changeStatus('{{ base64_encode($b->id) }}', 'banners', 'I')"
                                                        title="Change to Inactive"><i
                                                            class="text-success fas fa-toggle-on"></i></a>
                                                @else
                                                    <a href="javascript:void(0);"
                                                        onclick="changeStatus('{{ base64_encode($b->id) }}', 'banners', 'A')"
                                                        title="Change to Active"><i
                                                            class="text-danger fas fa-toggle-off"></i></a>
                                                @endif &nbsp;
                                                <a href="javascript:void(0);" onclick="edit('{{ base64_encode($b->id) }}')"
                                                    title="Edit"><i class="fas fa-edit"></i></a>
                                                &nbsp;
                                                <a href="javascript:void(0);"
                                                    onclick="delete_status('{{ base64_encode($b->id) }}', 'banners', 'D')"
                                                    title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $banner->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="pageModal" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pageModalLabel">
                            Banner <span id="modaltype">Add</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="$('#pageModal').modal('hide');">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.banner.banner') }}" method="post" enctype="multipart/form-data"
                        id="pageform">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Title <span class="req">*</span></label>
                                        <input type="text" name="banner_title" id="banner_title" class="form-control"
                                            placeholder="Banner Title" />
                                        @if ($errors->has('banner_title'))
                                            <span
                                                class="error"><small>{{ ucwords($errors->first('banner_title')) }}</small></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="image">Image <span class="req">*</span></label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            accept="image/*" />
                                        @if ($errors->has('image'))
                                            <span
                                                class="error"><small>{{ ucwords($errors->first('image')) }}</small></span>
                                        @endif
                                    </div>
                                    <div class="col-md-2 oldimg">
                                        <a href="" target="_blank"><img src="" class="img" id="editimg"
                                                alt="" style="margin-top: 35%" /></a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="rowid" id="rowid" />

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                                onclick="$('#pageModal').modal('hide');">
                                Close
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="readMore" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="container">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#readMore').modal('hide');">Close</button>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('script')
        <script>
            var content;
            $(function() {
                $("#bannertbl").dataTable({
                    bPaginate: false,
                    bInfo: false,
                    dom: "Bfrtip",
                    buttons: [{
                        text: "+ Add Banner",
                        attr: {
                            class: 'btn btn-success btn-sm'
                        },
                        action: function(e, dt, node, config) {
                            resetform();
                            $("#pageModal").modal("show");
                        },
                    }, ],
                    "aaSorting": [
                        [1, "asc"]
                    ],

                    "bAutoWidth": false,
                    "columnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]
                    }],
                });
            });

            function edit(rowid) {
                let url = "{{ route('admin.banner.banner.get') }}" + "/" + rowid;
                $.get(url, function(res) {
                    // console.log(res);
                    if (res.code == "200") {
                        // console.log(res.data);
                        resetform();
                        putvalue(res.data);
                        $("#pageModal").modal("show");
                    }
                });
            }

            function resetform() {
                $(".oldimg").hide();
                // content.setData("");
                $("#pageModal").find("#editimg").attr("src", "");
                $("#pageModal").find("#editimg").parent("a").attr("href", "");
                $("#pageform")[0].reset();
            }

            function putvalue(res) {
                $("#pageModal").find("#banner_title").val(res.title);
                // $("#pageModal").find("#heading").val(res.heading);
                // content.setData(res.content);
                $(".oldimg").show();
                $("#pageModal").find("#editimg").attr("src", res.avatar);
                $("#pageModal").find("#editimg").parent("a").attr("href", res.avatar);
                $("#pageModal").find("#rowid").val(res.id);
            }

            function changeStatus(rowid, tbl, status) {
                $.confirm({
                    title: "Are you sure?",
                    content: "Do you want to change the status?",
                    type: "red",
                    typeAnimated: true,
                    buttons: {
                        ok: {
                            text: "Yes",
                            btnClass: "btn-red",
                            action: function() {
                                $.ajax({
                                    url: "{{ route('admin.status.change', ['type' => 'banner']) }}",
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
                                    url: "{{ route('admin.delete_status', ['type' => 'banner']) }}",
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
                $(".error").hide();
            }, 4500);
        </script>
        <script>
            $(document).ready(function() {
                // alert('sd');
                "use strict";
                $("#pageform")
                    .formValidation({
                        message: "This value is not valid",
                        fields: {
                            banner_title: {
                                validators: {
                                    notEmpty: {
                                        message: "Title is required",
                                    },
                                },
                            },
                            // image: {
                            //     validators: {
                            //         notEmpty: {
                            //             message: "Image is required",
                            //         },
                            //     },
                            // },
                            

                        },

                    });
            });
        </script>
        @if (@$errors->has('banner_err'))
            @if (@$errors->has('banner_err_rowid'))
                <script>
                    let rowid = "{{ @$errors->first('technology_err_rowid') }}";
                    edit(rowid);
                </script>
            @else
                <script>
                    $("#pageModal").modal("show");
                </script>
            @endif
        @endif @endpush
