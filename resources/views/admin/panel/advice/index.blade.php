@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Advice | Admin')

@push('style')
    <style>
        .error {
            color: red;
        }

        .req {
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
                        <h1 class="m-0">Advice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Advice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" id="advicetbl">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    {{-- <th data-orderable="false">Description</th> --}}
                                    <th class="text-center" data-orderable="false">Status</th>
                                    <th class="text-center" data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($advices as $advice)
                                    <tr>
                                        <td>{{ ucwords($advice->name) }}</td>
                                        {{-- <td class="showReadMore">
                                            {!! $advice->description !!}
                                        </td> --}}
                                        <td class="text-center"><span
                                                class="{{ $advice->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $advice->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($advice->status == 'A')
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($advice->id) }}', 'advice_models', 'I')"
                                                    title="Change {{ ucwords($advice->heading) }} to Inactive"
                                                   ><i class="text-success fas fa-toggle-on"></i></a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($advice->id) }}', 'advice_models', 'A')"
                                                    title="Change {{ ucwords($advice->heading) }} to Active"
                                                   ><i class="text-danger fas fa-toggle-off"></i></a>
                                            @endif
                                            &nbsp;
                                            <a href="javascript:void(0);"
                                                onclick="edit('{{ base64_encode($advice->id) }}')"
                                                title="Edit {{ ucwords($advice->heading) }}"><i
                                                    class="fas fa-edit"></i></a>
                                                    &nbsp;
                                            <a href="javascript:void(0);"
                                                onclick="delete_status('{{ base64_encode($advice->id) }}', 'advice_models', 'D')"
                                                title="Delete {{ ucwords($advice->heading) }}"><i
                                                    class="text-danger fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $advices->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="advice" tabindex="-1" aria-labelledby="adviceLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adviceLabel">Advice <span id="modaltype">Info</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#advice').modal('hide');">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.advice') }}" method="post" enctype="multipart/form-data" id="adviceform">
                    @csrf
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="heading">Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    @if ($errors->has('name'))
                                        <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Content</label>
                                    <textarea name="content" id="content" class="form-control"></textarea>
                                    @if ($errors->has('content'))
                                        <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="rowid" id="rowid">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Add</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                            onclick="$('#advice').modal('hide');">Close</button>

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
            ClassicEditor.create(document.querySelector('#content'))
                .then(editor => {
                    content = editor;
                    content.editing.view.change(writer => {
                        writer.setStyle('height', '200px', content.editing.view.document.getRoot());
                    });
                })
                .catch(error => {
                    console.error(error)
                });

            $('#advicetbl').dataTable({
                "bInfo": false,
                dom: 'Bfrtip',
                "bPaginate": false,
                buttons: [{
                    text: '+ Add Advice',
                    attr: {
                        class: 'btn btn-success btn-sm'
                    },
                    action: function(e, dt, node, config) {
                        resetform();
                        $('#advice').modal('show');
                    }
                }],
                'columnDefs': [{
                    'targets': [1],
                    'orderable': false,
                }]
            });
            //show or hide for read more function
            var maxLength = 60;
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
            let url = "{{ route('admin.advice.get') }}" + '/' + rowid;
            $.get(url, function(res) {
                if (res.code == '200') {
                    resetform();
                    putvalue(res.data);
                    $('#advice').modal('show');
                }
            });
        }

        function resetform() {
            $('.oldimg').hide();
            content.setData('');
            $('#advice').find('#editimg').attr('src', '');
            $('#advice').find('#editimg').parent('a').attr('href', '');
            $('#adviceform')[0].reset();
        }

        function putvalue(res) {
            $('#advice').find('#name').val(res.name);
            if (res.description != null) {
                content.setData(res.description);
            }
            $('.oldimg').show();
            $('#advice').find('#editimg').attr('src', res.avatar);
            $('#advice').find('#editimg').parent('a').attr('href', res.avatar);
            $('#advice').find('#rowid').val(res.id);
        }

        function changeStatus(rowid, tbl, status) {
            $.confirm({
                title: "Are you sure?",
                content: "Do you want to change the status?",
                type: "red",
                typeAnimated: true,
                buttons: {
                    ok: {
                        text: 'Yes',
                        btnClass: 'btn-red',
                        action: function() {
                            $.ajax({
                                url: "{{ route('admin.status.change', ['type' => 'advice']) }}",
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
                                url: "{{ route('admin.delete_status', ['type' => 'advice']) }}",
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
            $("#adviceform")
                .formValidation({
                    message: "This value is not valid",
                    fields: {
                        name: {
                            validators: {
                                notEmpty: {
                                    message: "Name is required",
                                },
                            },
                        }


                    },
                })
        });
    </script>
    @if (@$errors->has('advice_err'))
        @if (@$errors->has('advice_err_rowid'))
            <script>
                let rowid = "{{ @$errors->first('advice_err_rowid') }}";
                edit(rowid);
            </script>
        @else
            <script>
                $('#advice').modal('show');
            </script>
        @endif
    @endif
@endpush
