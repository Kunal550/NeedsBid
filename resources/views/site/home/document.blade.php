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
            <div class="right-main">
                <form action="{{ route('documents.create') }}" method="POST" enctype='multipart/form-data' id="signupForm" class="row">
                    @csrf
                    <div class="form-group col-md-6">
                        <div class="d-flex">
                            <div class="pr-2">
                                <label for="business_doc">Business Document</label>
                                <div class="inputmain">
                                    @foreach ($documents as $document)
                                    <p><strong>{{ $document->document_type }}:&nbsp;</strong>
                                        <a href="{{ URL::to('public/uploads/admin/documents/' . $document->file_path) }}" target="_blank">{{ $document->file_path }}</a>
                                    </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>

</script>
@endpush