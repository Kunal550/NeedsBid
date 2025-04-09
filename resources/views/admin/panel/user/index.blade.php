@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Customer | Admin')

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
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                        <li class="breadcrumb-item">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
                <a class="btn btn-success btn-sm add-btn pull-right flotleft-custom" href="{{ route('admin.users.user-create') }}">+ Create User</a>
                    <table class="table table-striped table-bordered" id="customertbl">
                        <thead>
                            <tr>
                                {{-- <th>##</th> --}}
                                <th data-orderable="false">Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th data-orderable="false">Address</th>
                                <th class="text-center" data-orderable="false">Status</th>
                                <th class="text-center" data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $key => $customer)
                            <tr>
                                {{-- <td>{{ $key + 1 }}</td> --}}
                                <td class="text-center"><img
                                        src="{{ $customer->avatar }}"
                                        class="img" alt=""></td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>
                                    @foreach($customer->getRoleNames() as $role)
                                    <button type="button" class="badge badge-success mx-1">{{$role}}</button>
                                    @endforeach
                                </td>

                                <td>{{ $customer->address }}</td>
                                <td class="text-center">
                                    <span class="{{ $customer->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $customer->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                </td>

                                <td class="text-center">
                                    <a href="user-edit/{{ base64_encode($customer->id) }}" title="Edit"><i class="fas fa-edit"></i></a>
                                    &nbsp;
                                    <a href="javascript:void(0);"
                                        onclick="delete_status('{{ base64_encode($customer->id) }}', 'users', 'D')"  title="Delete"><i class="text-danger fas fa-trash"></i></a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $customers->appends(Request::except('page'))->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('script')


<script>
    function NewPassword() {
        var x = document.getElementById("new_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function ConfirmPassword() {
        var x = document.getElementById("confirm_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
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
                            url: "{{ route('admin.users.delete-user') }}",
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
@if (@$errors->has('customer_err'))
@if (@$errors->has('customer_err_rowid'))
<script>
    let rowid = "{{ @$errors->first('customer_err_rowid') }}";
    edit(rowid);
</script>
@else
<script>
    $('#pageModal').modal('show');
</script>
@endif
@endif
@endpush