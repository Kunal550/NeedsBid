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
                    <h1 class="m-0">Customers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                        <li class="breadcrumb-item">Customers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
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
                                    @if ($customer->status == 'A')
                                    
                                    <a href="javascript:void(0);"
                                        onclick="changeStatus('{{ base64_encode($customer->id) }}', 'users', 'I')"
                                        title="Change to Inactive"><i
                                            class="text-success fas fa-toggle-on"></i></a>
                                    @else
                                    <a href="javascript:void(0);"
                                        onclick="changeStatus('{{ base64_encode($customer->id) }}', 'users', 'A')"
                                        title="Change to Active"><i
                                            class="text-danger fas fa-toggle-off"></i></a>
                                    @endif
                                    &nbsp;
                                    <a href="javascript:void(0);"
                                        onclick="edit('{{ base64_encode($customer->id) }}')" title="Edit"><i class="fas fa-edit"></i></a>
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

<div class="modal fade" id="pageModal" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pageModalLabel">User <span id="modaltype">Add</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="$('#pageModal').modal('hide');">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.list') }}" method="post" enctype="multipart/form-data" id="pageform">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Name<span class="req">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Name">
                                @if ($errors->has('name'))
                                <span class="error"><small>{{ ucwords($errors->first('name')) }}</small></span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="">Email<span class="req">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Email">
                                @if ($errors->has('email'))
                                <span class="error"><small>{{ ucwords($errors->first('email')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="">Password<span class="req">*</span></label>
                                <input type="password" name="new_password" minlength="6" maxlength="12" id="new_password" class="form-control"
                                    placeholder="Password">
                                <a class="i_icon" href="javascript:void(0);" onclick="NewPassword()"><i
                                        class="fa fa-eye"></i></a>
                                @if ($errors->has('new_password'))
                                <span class="error"><small>{{ ucwords($errors->first('new_password')) }}</small></span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="">Confirm Password<span class="req">*</span></label>
                                <input type="password" name="confirm_password" minlength="6" maxlength="12" id="confirm_password" class="form-control"
                                    placeholder="Confirm Password">
                                <a href="javascript:void(0);" class="i_icon" onclick="ConfirmPassword()">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if ($errors->has('confirm_password'))
                                <span class="error"><small>{{ ucwords($errors->first('confirm_password')) }}</small></span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 form-group">
                                <label for="role">Roles <span class="req">*</span></label>
                                <select name="roles[]" class="form-select role" id="role" multiple required>
                                    <option value="">Select Roles</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ base64_encode($role['name']) }}">{{ $role['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rowid" id="rowid">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Add</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                        onclick="$('#pageModal').modal('hide');">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    var content;
    $(function() {
        $('#customertbl').dataTable({
            "bInfo": false,
            dom: 'Bfrtip',
            "bPaginate": false,
            buttons: [{
                text: '+ Add User',
                attr: {
                    class: 'btn btn-success btn-sm'
                },
                action: function(e, dt, node, config) {
                    resetform();
                    $('#pageModal').modal('show');
                }
            }],
            'columnDefs': [{
                'targets': [1],
                'orderable': false,
            }]
        });

    });

    function edit(rowid) {
        let url = "{{ route('admin.users.user.get') }}" + '/' + rowid;
        $.get(url, function(res) {
            // console.log(res);
            if (res.code == '200') {
                resetform();
                putvalue(res.data);
                $('#pageModal').modal('show');
            }
        });
    }



    function resetform(isEdit = false) {
        const $form = $('#pageform');

        // Reset form fields
        $form[0].reset();
        $('#role').val([]).trigger('change'); // if using multiselect

        $('#pageModal').find('#name').val('');
        $('#pageModal').find('#email').val('');
        $('#pageModal').find('#new_password').val('');
        $('#pageModal').find('#confirm_password').val('');
        $('#pageModal').find('#rowid').val('');

        // Destroy previous validator instance (if exists)
        $form.data('formValidation')?.destroy();

        // Common validators
        const validators = {
            name: {
                validators: {
                    notEmpty: {
                        message: "Name is required",
                    },
                },
            },
            email: {
                validators: {
                    notEmpty: {
                        message: "Email is required",
                    },
                    emailAddress: {
                        message: "Enter a valid email",
                    }
                },
            },
        };

        // If it's not edit mode, add password validators
        if (!isEdit) {
            validators.new_password = {
                validators: {
                    notEmpty: {
                        message: "Password is required",
                    },
                },
            };
            validators.confirm_password = {
                validators: {
                    notEmpty: {
                        message: "Confirm Password is required",
                    },
                    identical: {
                        field: "new_password",
                        message: "Passwords do not match",
                    },
                },
            };
        }

        // Re-initialize form validation
        $form.formValidation({
            message: "This value is not valid",
            fields: validators,
        });
    }

    function openAddUserModal() {
        resetform(false); // false = not edit
        $('#pageModal').modal('show');
    }

    function putvalue(res) {
        const selectedRoles = res.roles.map(role => {
            return btoa(role.name); // btoa = base64 encode
        });
        $('#pageModal').find('#name').val(res.name);
        $('#pageModal').find('#email').val(res.email);
        $('#pageModal').find('#role').val(selectedRoles).trigger('change');
        $('#new_password, #confirm_password').val('');
        $('#pageModal').find('#rowid').val(res.id);
        $('#new_password').val('');
        $('#confirm_password').val('');
        const $form = $('#pageform');
        $form.data('formValidation')?.destroy();

        $form.formValidation({
            message: "This value is not valid",
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Name is required",
                        },
                    },
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: "Email is required",
                        },
                        emailAddress: {
                            message: "Enter a valid email",
                        }
                    },
                },

            },
        });
    }



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
                            url: "{{ route('admin.status.change', ['type' => 'blog']) }}",
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
                            url: "{{ route('admin.delete_status', ['type' => 'users']) }}",
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