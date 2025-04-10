@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'How It Work | Admin')

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
                <div class="col-md-12 pull-right">
                    @can('how_it_work-create')
                    <a class="btn btn-success btn-sm add-btn pull-right"
                        href="{{ route('admin.cms.how_it_work.create') }}">+ Create</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
                   
                    <table class="table table-striped table-bordered" id="how_it_worktbl">
                        <thead>
                            <tr>
                                <th data-orderable="false">Image</th>
                                <th>Name</th>
                                <th class="text-center" data-orderable="false">Status</th>
                                <th class="text-center" data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($how_it_works as $key => $how_it_work)
                            <tr>
                                <td class="text-center"><img src="{{$how_it_work->avatar}}" class="img" alt=""></td>
                                <td>{{ $how_it_work->name }}</td>
                                <td class="text-center"><span
                                        class="{{ $how_it_work->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $how_it_work->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="text-center">
                                    @can('how_it_work-edit')
                                    <a href="edit/{{ base64_encode($how_it_work->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    &nbsp;
                                    @can('how_it_work-delete')
                                    <a href="javascript:void(0);"
                                        onclick="delete_status('{{ base64_encode($how_it_work->id) }}', 'how_it_work_models', 'D')"
                                        title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $how_it_works->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

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
                            url: "{{ route('admin.cms.how_it_work.delete') }}",
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