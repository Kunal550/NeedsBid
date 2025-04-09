@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Faq | Admin')

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

    .morecontent span {
        display: none;
    }

    .ReadMore {
        display: visible;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
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
                    <h1 class="m-0">FAQ's</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                        <li class="breadcrumb-item">FAQ's</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row table-resposive">
                <div class="col-md-12">
                <a class="btn btn-success btn-sm add-btn pull-right flotleft-custom" href="{{ route('admin.cms.faq.create') }}">+ Create</a>

                    <table class="table table-striped table-bordered" id="faqtbl">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th class="text-center" data-orderable="false">Status</th>
                                <th class="text-center" data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faq_details as $key => $faq_detail)
                            <tr>
                                <td>{{ $faq_detail->question }}</td>

                                <td class="text-center"><span
                                        class="{{ $faq_detail->status == 'A' ? 'text-success' : 'text-warning' }}">{{ $faq_detail->status == 'A' ? 'Active' : 'Inactive' }}</span>
                                </td>


                                <td class="text-center">

                                    <a href="edit/{{ base64_encode($faq_detail->id) }}"  title="Edit"><i class="fas fa-edit"></i></a>

                                    <a href="javascript:void(0);" onclick="delete_status('{{ base64_encode($faq_detail->id) }}', 'faq_models', 'D')"
                                        title="Delete"><i class="text-danger fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $faq_details->appends(Request::except('page'))->links('pagination::bootstrap-5') }}


                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    var content;
    $(function() {
        ClassicEditor.create(document.querySelector('#answer'))
            .then(editor => {
                content = editor;
                content.editing.view.change(writer => {
                    writer.setStyle('height', '200px', content.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error(error)
            });

    });


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
                            url: "{{ route('admin.cms.faq.delete') }}",
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

@if (@$errors->has('faq_err'))
@if (@$errors->has('faq_err_rowid'))
<script>
    let rowid = "{{ @$errors->first('faq_err_rowid') }}";
    edit(rowid);
</script>
@else
<script>
    $('#pageModal').modal('show');
</script>
@endif
@endif
@endpush