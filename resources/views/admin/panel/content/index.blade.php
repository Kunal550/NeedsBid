@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Admin | Content')
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
                <div class="col-md-12 pull-right">
                    @can('content-create')
                    <a class="btn btn-success btn-sm add-btn pull-right"
                        href="{{ route('admin.content.content_create') }}">+ Create Content</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="producttbl">
                        <thead>
                            <tr>
                                <th data-orderable="false">Image</th>
                                <th>Title</th>
                                <th>Position</th>
                                <th class="text-center" data-orderable="false">Status</th>
                                <th class="text-center" data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contents as $key => $content)
                            <tr>

                                <td class="text-center">
                                    <img src="{{ $content->avatar }}" class="img" alt="" />
                                </td>
                                <td>{{ $content->title }}</td>

                                <td>{{ $content->is_below_brand == 1 ? 'below_brand' : 'below_featured_product' }}
                                </td>
                                <td class="text-center"><span
                                        class="{{ $content->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $content->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                </td>

                                <td class="text-center">
                                    @can('content-edit')
                                    <a href="editContent/{{ base64_encode($content->id) }}" title="Edit"><i
                                            class="fas fa-edit"></i></a>
                                    @endcan
                                    &nbsp;
                                    @can('content-delete')
                                    <a href="javascript:void(0);"
                                        onclick="delete_status('{{ base64_encode($content->id) }}', 'content_models', 'D')"
                                        title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $contents->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

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
                            url: "{{ route('admin.content.delete') }}",
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