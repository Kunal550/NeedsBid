@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Project Category | Admin')

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
                    <h1 class="m-0">Project Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                        <li class="breadcrumb-item">Project Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
                <a class="btn btn-success btn-sm add-btn pull-right flotleft-custom" href="{{ route('admin.project-category.create') }}">+ Create Category</a>
                    <table class="table table-striped table-bordered" id="project_category">
                        <thead>
                            <tr>
                                <th data-orderable="false">Image</th>
                                <th>Name</th>
                                <th class="text-center" data-orderable="false">Status</th>
                                <th class="text-center" data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project_categories as $key => $project_category)
                            <tr>
                                <td class="text-center"><img src="{{ $project_category->avatar }}" class="img" alt=""></td>
                                <td>{{ ucwords($project_category->name) }}</td>
                                <td class="text-center"><span
                                        class="{{ $project_category->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $project_category->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="text-center">
                                    
                                    <a href="edit/{{ base64_encode($project_category->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                                    &nbsp;
                                    <a href="javascript:void(0);"
                                        onclick="delete_status('{{ base64_encode($project_category->id) }}', 'project_categories', 'D')"
                                        title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $project_categories->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

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
                            url: "{{ route('admin.project-category.delete') }}",
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
    </script>
@endpush
