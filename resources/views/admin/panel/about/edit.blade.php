@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'About | Edit | Admin')

@push('style')
    <style>
        .error {
            color: red;
        }

        .req {
            color: red;
        }

        small.help-block {
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

        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .select2-container .select2-selection--single {
            height: 38px;
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
    <div class="content-wrapper">
        <div class="content">
            <div class="container">

                <form action="{{ route('admin.about.about-update') }}" method="post" enctype="multipart/form-data"
                    id="aboutform">

                    @csrf
                    <input type="hidden" name="pages_id" id="pages_id" value="{{ $pages->id }}">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Parent Name <span class="req">*</span></label>
                                <select name="parent_id" class="form-select parent_id" id="parent_id">
                                    <option value="">Select Parent</option>
                                    <option value="{{ base64_encode(1) }}" {{ $pages->parent_id == 1 ? 'selected' : '' }}>
                                        Stone Fabricators</option>

                                    <option value="{{ base64_encode(2) }}" {{ $pages->parent_id == 2 ? 'selected' : '' }}>
                                        Commercial</option>

                                    <option value="{{ base64_encode(3) }}" {{ $pages->parent_id == 3 ? 'selected' : '' }}>
                                        Residential</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name <span class="req">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $pages->name }}" placeholder="Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Description</label>
                            <textarea name="content" id="content" value="{!! $pages->description !!}" class="form-control">{!! $pages->description !!}</textarea>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="image"> Image </label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <a href="" target="_blank"> <img
                                    src="{{ URL::to('public/uploads/about/' . $pages->image) }}" class="img"
                                    id="editimg" alt=""></a>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit" name="btn_type" value="continue">Save &
                        Continue</button>
                    <a href="{{ route('admin.about.list') }}" type="button" class="btn btn-primary">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        ClassicEditor.create(document.querySelector("#content"))
            .then((editor) => {
                content = editor;
                editor.editing.view.change(writer => {
                    writer.setStyle('height', '200px', editor.editing.view.document.getRoot());
                });
            })
            .catch((error) => {
                console.error(error);
            });






        $(document).on('click', '.del-gallery-img', function(e) {

            var id = $(this).data('id');
            // alert(id)
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
        });
    </script>
@endpush
