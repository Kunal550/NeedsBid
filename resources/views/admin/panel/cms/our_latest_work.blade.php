@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Latest Work | Admin')

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

        .morecontent span {
            display: none;
        }

        .ReadMore {
            display: visible;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Latest Work</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                            <li class="breadcrumb-item">Latest Work</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" id="latestwrktbl">
                            <thead>
                                <tr>
                                    <th>##</th>
                                    <th data-orderable="false">Image</th>
                                    <th>Name</th>
                                    {{-- <th data-orderable="false">Description</th> --}}
                                    <th class="text-center" data-orderable="false">Status</th>
                                    <th class="text-center" data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_works as $key => $latest_work)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="text-center">
                                            <img src="{{ $latest_work->avatar }}" class="img" alt="" />
                                        </td>
                                        <td>{{ $latest_work->name }}</td>

                                        {{-- <td class="showReadMore">{!! $latest_work->description !!}</td> --}}
                                        <td class="text-center"><span
                                                class="{{ $latest_work->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $latest_work->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                        </td>

                                        <td class="text-center">
                                            @if ($latest_work->status == 'A')
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($latest_work->id) }}', 'our_latest_works', 'I')"
                                                    title="Change to Inactive"><i
                                                        class="text-success fas fa-toggle-on"></i></a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($latest_work->id) }}', 'our_latest_works', 'A')"
                                                    title="Change to Active"><i
                                                        class="text-danger fas fa-toggle-off"></i></a>
                                            @endif
                                            &nbsp;
                                            <a href="javascript:void(0);"
                                                onclick="edit('{{ base64_encode($latest_work->id) }}')" title="Edit"><i
                                                    class="fas fa-edit"></i></a>

                                            <a href="javascript:void(0);"
                                                onclick="delete_status('{{ base64_encode($latest_work->id) }}', 'our_latest_works', 'D')"
                                                title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pageModal" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pageModalLabel">Latest Work <span id="modaltype">Add</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#pageModal').modal('hide');">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.cms.our-latest-work') }}" method="post" enctype="multipart/form-data"
                    id="pageform">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Name<span class="req">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    @if ($errors->has('name'))
                                        <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                    @endif
                                </div>
                            
                                {{-- <div class="col-md-12 form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                    @if ($errors->has('description'))
                                        <span
                                            class="error"><small>{{ ucwords($errors->first('description')) }}</small></span>
                                    @endif

                                </div> --}}
                            
                                <div class="col-md-12 form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        accept="image/*" />
                                    @if ($errors->has('image'))
                                        <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span>
                                    @endif
                                </div>
                                <div class="col-md-6 oldimg form-group">
                                    <a href="" target="_blank"><img src="" class="rounded w-100" id="editimg" alt="" style="margin-top: 30px;width: 40px !important;height: 40px;"/></a>
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
    <div class="modal fade" id="readMore" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#readMore').modal('hide');">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="container">
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var content;
        $(function() {

            /** content */
            // ClassicEditor.create(document.querySelector('#description'))
            //     .then(editor => {
            //         content = editor;
            //         content.editing.view.change(writer => {
            //             writer.setStyle('height', '200px', content.editing.view.document.getRoot());
            //         });
            //     })
            //     .catch(error => {
            //         console.error(error)
            //     });

            $('#latestwrktbl').dataTable({
                "bInfo": false,
                dom: 'Bfrtip',
                buttons: [{
                    text: '+ Add Latest Work',
                    attr: {
                        class: 'btn btn-success btn-sm'
                    },
                    action: function(e, dt, node, config) {
                        resetform();
                        $('#pageModal').modal('show');
                    }
                }],
                'columnDefs': [{
                    'targets': [0,2],
                    'orderable': false,
                }]
            });
            //show or hide for read more function
            var maxLength = 50;
            var ellipsestext = "...";
            var moretext = "Read more";
            var lesstext = "Read less";
            $(".showReadMore").each(function() {
                var myStr = $(this).text();
                if ($.trim(myStr).length > maxLength) {
                    var newStr = myStr.substring(0, maxLength);
                    var removedStr = myStr.substr(maxLength, $.trim(myStr).length - maxLength);
                    var Newhtml = newStr + '<span class="moreellipses">' + ellipsestext +
                        '</span><span class="morecontent"><span>' + removedStr +
                        '</span>&nbsp;&nbsp;<a href="javascript:void(0)" class="ReadMore">' + moretext +
                        '</a></span>';
                    $(this).html(Newhtml);
                }
            });

            $(".ReadMore").click(function() {
                var content = $(this).parents('.morecontent').html();
                console.log(content);
                $('#readMore .modal-body').html(content)
                $('#readMore').modal('show')
                $('#readMore').find('.ReadMore').hide();
            });
            //End show or hide for read more function
        });

        function edit(rowid) {
            let url = "{{ route('admin.cms.get-row', ['type' => 'latest_work']) }}" + '/' + rowid;
            $.get(url, function(res) {
                console.log(res);
                if (res.code == '200') {
                    resetform();
                    putvalue(res.data);
                    $('#pageModal').modal('show');
                }
            });
        }

        function resetform() {
            $(".oldimg").hide();
            // content.setData("");
            $("#pageModal").find("#editimg").attr("src", "");
            $("#pageModal").find("#editimg").parent("a").attr("href", "");
            $('#pageModal').find('#name').val('');
            $('#pageModal').find('#image').val('');
            $('#pageModal').find('#rowid').val('');
        }

        function putvalue(res) {
            // console.log(res);
            $('#pageModal').find('#name').val(res.name);
            // if (res.description != null) {
            //     content.setData(res.description);
            // }
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
                                url: "{{ route('admin.status.change', ['type' => 'latest_work']) }}",
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
                                url: "{{ route('admin.delete_status', ['type' => 'latest_work']) }}",
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
            // alert('sd');
            "use strict";
            $("#pageform")
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

                        // client_image: {
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
    @if (@$errors->has('latest_work_err'))
        @if (@$errors->has('latest_work_err_rowid'))
            <script>
                let rowid = "{{ @$errors->first('latest_work_err_rowid') }}";
                edit(rowid);
            </script>
        @else
            <script>
                $('#pageModal').modal('show');
            </script>
        @endif
    @endif
@endpush
