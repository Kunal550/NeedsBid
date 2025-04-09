@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'About | Admin')

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
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script> --}}
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
                        <a class="btn btn-success btn-sm add-btn pull-right" href="{{ route('admin.about.about.create') }}">+
                            Create About</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" id="servicestbl">
                            <thead>
                                <tr>
                                    <th data-orderable="false">Image</th>
                                    <th>Parent Name</th>
                                    <th>Name</th>
                                    <th class="text-center" data-orderable="false">Status</th>
                                    <th class="text-center" data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($pages as $page)
                                    <tr>
                                        <td class="text-center"><img src="{{ $page->avatar }}" class="img"
                                                alt=""></td>
                                        @if (!empty($page->about_to_pages->name))
                                            <td>
                                                {{ ucwords($page->about_to_pages->name) }}
                                            </td>
                                        @else
                                            <td style="text-align: center">--</td>
                                        @endif
                                        <td>{{ ucwords($page->name) }}</td>
                                        <td class="text-center"><span
                                                class="{{ $page->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $page->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($page->status == 'A')
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($page->id) }}', 'about_models', 'I')"
                                                    title="Change {{ ucwords($page->heading) }} to Inactive"><i
                                                        class="text-success fas fa-toggle-on"></i></a>
                                            @else
                                                <a href="javascript:void(0);"
                                                    onclick="changeStatus('{{ base64_encode($page->id) }}', 'about_models', 'A')"
                                                    title="Change {{ ucwords($page->heading) }} to Active"><i
                                                        class="text-danger fas fa-toggle-off"></i></a>
                                            @endif
                                            &nbsp;
                                            <a href="edit-about/{{ base64_encode($page->id) }}"
                                                title="Edit {{ ucwords($page->heading) }}"><i class="fas fa-edit"></i></a>
                                            &nbsp;
                                            <a href="javascript:void(0);"
                                                onclick="delete_status('{{ base64_encode($page->id) }}', 'about_models', 'D')"
                                                title="Delete {{ ucwords($page->heading) }}"><i
                                                    class="text-danger fas fa-trash"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $pages->appends(Request::except('page'))->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function() {
            $('#servicestbl').dataTable({
                "bInfo": false,
                "bPaginate": false,
                'columnDefs': [{
                    'targets': [0, 2],
                    'orderable': false,
                }]
            });


        });
        $(document).on('click', '.del-gallery-img', function(e) {
            var id = $(this).data('id');
            $.confirm({
                title: 'Confirm!',
                content: 'Do you want to Delete the Image?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    ok: {
                        text: 'Yes',
                        btnClass: 'btn-red',
                        action: function() {
                            $.ajax({
                                url: "{{ route('admin.service.delete-image') }}",
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'id': id

                                },
                                type: 'POST',
                                success: function(res) {
                                    if (res.code == '200') {
                                        $.alert(res.msg);
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
                                url: "{{ route('admin.status.change', ['type' => 'service']) }}",
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
                                url: "{{ route('admin.delete_status', ['type' => 'service']) }}",
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
            content.setData(res.content);
            $('.oldimg').show();
            $('#serviceModal').find('#editimg').attr('src', res.avatar);
            $('#serviceModal').find('#editimg').parent('a').attr('href', res.avatar);
            $('#serviceModal').find('#rowid').val(res.id);
        }

        function edit(rowid) {
            let url = "{{ route('admin.service.service.get') }}" + '/' + rowid;
            $.get(url, function(res) {
                if (res.code == '200') {
                    resetform();
                    putvalue(res.data);
                    $('#serviceModal').modal('show');
                }
            });
        }
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
    </script>
@endpush
