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

    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permission</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.permissions.permission-create') }}" class="btn btn-sm btn-primary">Add</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="collectionTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.permissions.permission-edit', encrypt($permission->id)) }}"
                                    class="btn btn-sm btn-secondary">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.permissions.permission-delete', encrypt($permission->id)) }}" method="POST" onclick="confirm('Are you sure')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center bg-danger">Permission not created</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




@endsection
@push('script')
<script>
    $(function() {
        $('#collectionTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "responsive": true,
        });
    });
</script>
@endpush