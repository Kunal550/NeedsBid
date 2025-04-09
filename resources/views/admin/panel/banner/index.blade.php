@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Banner | Admin')

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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-12 pull-right">
                        <a class="btn btn-success btn-sm add-btn pull-right"
                            href="{{ route('admin.banner.banner-create') }}">+ Create Banner</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" id="bannerstbl">
                            <thead>
                                <tr>
                                    {{-- <th>##</th> --}}
                                    <th data-orderable="false">Image</th>
                                    <th>Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banner as $key => $b)
                                    <tr>
                                        {{-- <td>{{ $key + 1 }}</td> --}}
                                        <td class="text-center"><img src="{{ $b->avatar }}" class="img"
                                                alt=""></td>
                                        <td>{{ ucwords($b->title) }}</td>
                                        <td class="text-center"><span
                                                class="{{ $b->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $b->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($b->status == 'A')
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($b->id) }}', 'banners', 'I')"
                                                    title="Change to Inactive"><i
                                                        class="text-success fas fa-toggle-on"></i></a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($b->id) }}', 'banners', 'A')"
                                                    title="Change to Active"><i
                                                        class="text-danger fas fa-toggle-off"></i></a>
                                            @endif
                                            &nbsp;
                                            <a href="banner-edit/{{ base64_encode($b->id) }}" title="Edit"><i
                                                    class="fas fa-edit"></i></a>
                                            &nbsp;
                                            <a href="javascript:void(0);"
                                                onclick="delete_status('{{ base64_encode($b->id) }}', 'banners', 'D')"
                                                title="Delete"><i class="text-danger fas fa-trash"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $banner->appends(Request::except('page'))->links('pagination::bootstrap-5') }}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('script')
    <script>
        $(function  () {
       $('#bannerstbl').dataTable({
        "bPaginate": false,
        "bInfo": false,
           'columnDefs': [{
              'targets': [2,3], 
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
                                url: "{{ route('admin.status.change', ['type' => 'banner']) }}",
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
                                url: "{{ route('admin.banner.delete') }}",
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
