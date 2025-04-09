@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Pages | Admin')

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
                        <h1 class="m-0">Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                            <li class="breadcrumb-item">Pages</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-md-12">
                    <a class="btn btn-success btn-sm add-btn pull-right flotleft-custom" href="{{ route('admin.cms.pages.create') }}">+ Create Page</a>
                        <table class="table table-striped table-bordered" id="pagestbl">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="text-center"data-orderable="false">Status</th>
                                    <th class="text-center" data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pages as $key => $page)
                                    <tr>
                                        <td>{{ $page->name }}</td>
                                        <td class="text-center"><span
                                                class="{{ $page->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $page->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td class="text-center">
                                            
                                            <a href="edit/{{ base64_encode($page->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                                                &nbsp;
                                            <a href="javascript:void(0);"
                                                onclick="delete_status('{{ base64_encode($page->id) }}', 'page_models', 'D')" title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $pages->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('script')
    <script>
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
                                url: "{{ route('admin.cms.pages.delete') }}",
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
                        pages: {
                            validators: {
                                notEmpty: {
                                    message: "Page title is required",
                                },
                            },
                        },



                    },

                });
        });
    </script>
    @if (@$errors->has('pages_err'))
        @if (@$errors->has('pages_err_rowid'))
            <script>
                let rowid = "{{ @$errors->first('pages_err_rowid') }}";
                edit(rowid);
            </script>
        @else
            <script>
                $('#pageModal').modal('show');
            </script>
        @endif
    @endif
@endpush
