@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Category | Admin')
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">{{ $title }}</h3>
                                <div class="box-header-btn">
                                    <div class="box-header-btn">
                                        <a href="{{route('admin.categories.create')}}" class="btn bg-navy btn-flat margin">+ Create New</a>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example2" class="table table-bordered table-hover dataTable"
                                                role="grid" aria-describedby="example2_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th>Sl.</th>
                                                        <th width="100px">Image</th>
                                                        <th>Category</th>
                                                        <th>Parent</th>
                                                        <th>Slug</th>
                                                        <th>Created</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.categories.categorylist') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'thumbnail',
                        name: 'thumbnail',
                        orderable: false,
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'parent',
                        name: 'parent',
                        orderable: false,
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'slug',
                        name: 'slug',
                        orderable: false,
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'created',
                        name: 'created',
                        orderable: false,
                        sortable: false,
                        searchable: true
                    },
                    {
                        data: 'edit',
                        name: 'edit'
                    },
                    
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-user', function() {
                var id = $(this).data('id');
                Swal.fire({
                    text: "Are you sure want to delete?",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    confirmButtonColor: "#dd4b39",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var bg = "#000";
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.categories.delete') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                            },
                            beforeSend: function() {
                                $(".page-loader").show();
                            },
                            success: function(response) {
                                // console.log(response);
                                location.reload();
                            },
                        });
                    }
                });
                return false;
            });
        });
    </script>
@endsection
