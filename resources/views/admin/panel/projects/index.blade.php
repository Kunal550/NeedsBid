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

    .morecontent span {
        display: none;
    }

    .ReadMore {
        display: visible;
    }

    .flotleft-custom {
        float: left;
        margin-bottom: 15px;
        position: relative;
        z-index: 9;
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

                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
                    <a class="btn btn-success btn-sm add-btn pull-right flotleft-custom" href="{{ route('admin.projects.project-create') }}">+ Create Project</a>
                    <table class="table table-striped table-bordered" id="projecttbl">
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
                                    
                                    <a href="project-edit/{{ base64_encode($project->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
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

@endsection
@push('script')
<script>
    $(function() {
        $('#projecttbl').dataTable({
            dom: 'Bfrtip',
            "bPaginate": false,
            'columnDefs': [{
                'targets': [3],
                'orderable': false,
            }]
        });

    });

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
                            url: "{{ route('admin.projects.delete') }}",
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

    function resetform() {
        $('.oldimg').hide();
        content.setData('');
        $('#serviceModal').find('#editimg').attr('src', '');
        $('#serviceModal').find('#editimg').parent('a').attr('href', '');
        $('#serviceform')[0].reset();
    }

    function putvalue(res) {
        $('#serviceModal').find('#name').val(res.name);
        if (res.content != null) {
            content.setData(res.content);
        }
        $('.oldimg').show();
        $('#serviceModal').find('#editimg').attr('src', res.avatar);
        $('#serviceModal').find('#editimg').parent('a').attr('href', res.avatar);
        $('#serviceModal').find('#rowid').val(res.id);
    }

    
    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@endpush