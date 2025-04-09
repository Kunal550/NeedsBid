@extends('site.layout.commonLayout')
@push('style')
    <style>
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
            <div class="col-md-4">
                @include('site.auth.layout.sidebar')
            </div>
            <div class="col-md-8">
                <form action="{{ route('update.business-docs') }}" method="POST" enctype='multipart/form-data'
                    id="signupForm">
                    @csrf
                    <input type="hidden" name="account_id" value="{{ $business_docs->id }}">

                    {{-- {{dd($business_docs->business_doc)}} --}}
                    <div class="form-group">
                        <label for="business_doc">Business Document</label>
                        <input class="form-control" type="file" name="business_doc" id="business_doc" value="">

                        <iframe src="{{ URL::to('public/uploads/business_doc/' . $business_docs->business_doc) }}" width="100px" height="100px"></iframe>


                        {{-- <a href="" target="_blank"> <img
                                src="{{ URL::to('public/uploads/business_doc/' . $business_docs->business_doc) }}"
                                class="img" class="img" id="editimg" style="width:30%" alt=""></a> --}}
                        @if ($errors->has('business_doc'))
                            <span class="error"><small>{{ ucwords($errors->first('business_doc')) }}</small></span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Docs</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
    </script>
@endpush
