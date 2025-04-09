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
                <h3 class="card-title">Sub Category Table</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.subcategory.create') }}" class="btn btn-sm btn-info">New</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="subcategoryTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $cat)
                        <tr>
                            <td>{{ $cat->name }}</td>
                            <td><a href="{{ route('admin.subcategory.edit', encrypt($cat->id)) }}"
                                    class="btn btn-sm btn-primary">Edit</a></td>
                            <td>
                                <form action="{{ route('admin.subcategory.destroy', encrypt($cat->id)) }}"
                                    method="POST" onsubmit="return confirm('Are sure want to delete?')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
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
        $('#subcategoryTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "responsive": true,
        });
    });
</script>
@endpush