@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Permission | Admin')

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
                <div class="col-md-12 pull-right">
                    @can('permission-create')
                    <a class="btn btn-success btn-sm add-btn pull-right"
                        href="{{ route('admin.permissions.permission-create') }}">+ Create</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered" id="feedbcktbl">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $permission)
                            <tr>

                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->created_at }}</td>


                                <td class="text-center">
                                    @can('permission-edit')

                                    <a href="{{ route('admin.permissions.permission-edit', encrypt($permission->id)) }}" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    &nbsp;
                                    @can('permission-delete')
                                    <a href="javascript:void(0);"
                                        onclick="delete_status('{{ base64_encode($permission->id) }}', 'permissions', 'D')"
                                        title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->appends(Request::except('page'))->links('pagination::bootstrap-5') }}


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
                            url: "{{ route('admin.permissions.delete') }}",
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


@endpush