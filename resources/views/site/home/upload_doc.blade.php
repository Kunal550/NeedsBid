@extends('site.layout.commonLayout')
@push('style')
<style>
    .error {
        color: red;
    }

    .req {
        color: red;
    }

    .img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>
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
<div class="container emp-profile">

    <div class="row">
        <div class="col-md-12">

            <h2>Edit Profile</h2>

        </div>
        <div class="col-md-4 col-lg-3">
            <div class="left-bar">
                @include('site.auth.layout.sidebar')
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="right-main afrom-style">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="document_type">Document Type:</label>
                    <input type="text" name="document_type" class="form-control">
                    <div class="img-input buseness-dupload">
                        <div>
                            <input type="file" name="documents[]" multiple>
                            <p class="img-alter"><span class="text-danger">*</span>accept(.jpg, .png, .docx, .pdf)</p>
                           
                        </div>

                        <div class="form-group get-started-now">
                            <button type="submit" class="get-started-button"> <span>Upload</span></button>
                        </div>
                    </div>
                </form>


                <!-- <div class="form-group">
                        <div class="d-flex">
                            <div class="pr-2">
                                <div class="inputmain">
                                    @foreach ($documents as $document)
                                    <p><strong>{{ $document->document_type }}:&nbsp;</strong>
                                        <a href="{{ URL::to('public/uploads/admin/documents/' . $document->file_path) }}" target="_blank">{{ $document->file_path }}</a>


                                        <a href="javascript:void(0);" onclick="delete_document({{ $document->id }})">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </p>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div> -->
                <div class="form-group mt-5">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered m-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Document Type</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                <tr>
                                    <td class="font-weight-bold">{{ $document->document_type }}</td>
                                    <td>
                                        <a href="{{ URL::to('public/uploads/admin/documents/' . $document->file_path) }}"
                                            target="_blank"
                                            class="btn btn-link p-0">
                                            {{ $document->file_path }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" onclick="delete_document({{ $document->id }})">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    function delete_document(document_id) {
        $.confirm({
            title: "Are you sure?",
            content: "Do you want to delete this document?",
            type: "red",
            typeAnimated: true,
            buttons: {
                yes: {
                    text: "Yes",
                    btnClass: "btn-red",
                    action: function() {
                        $.ajax({
                            url: "{{ route('documents.destroy') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                document_id: document_id
                            },
                            success: function(res) {
                                if (res.code == "200") {

                                    toastr.success(res.msg);
                                    setTimeout(() => {
                                        location.reload();
                                    }, 3000);


                                }
                            },
                            error: function(err) {
                                toastr.error("Error deleting document.");
                            },
                        });
                    },
                },
                no: {
                    text: "No",
                },
            },
        });
    }
</script>
@endpush