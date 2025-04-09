@extends('admin.panel.layout.sitelayout')
@push('style')
    <style>
        .error{
            color: red;
        }
        .req{
            color: red;
        }
        .img{
            height: 30px;
            width: 30px;
            border-radius: 50%;
        }
        .oldimg{
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
  <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
@endpush
@section('content')
    @if(session('error'))
        <script>toastr.error("{{session('error')}}")</script>
    @endif
    @if(session('success'))
        <script>toastr.success("{{session('success')}}")</script>
    @endif 
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Training</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                            <li class="breadcrumb-item">Corporate</li>
                            <li class="breadcrumb-item active">Training</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{route('admin.corporate.training')}}" method="post" enctype="multipart/form-data" id="trainingform">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="page_heading">Page Heading</label>
                                    <input type="text" name="page_heading" value="{{@$training->page_heading}}" id="page_heading" class="form-control" placeholder="Page Heading">
                                    @if($errors->has('page_heading')) <span class="error"><small>{{ ucwords($errors->first('page_heading')) }}</small></span> @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    @if($errors->has('image')) <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span> @endif
                                </div>
                                <div class="col-md-12">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" class="form-control"></textarea>
                                    @if($errors->has('content')) <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span> @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" onclick="loader('show');$('#trainingform').submit();">Submit</button>
                                </div>
                            </div>  
                        </form>                                                                                     
                    </div>
                    <div class="col-md-5">
                        <img src="" class="oldimg" alt="" style="width: 100%;border-radius: 5%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    let pagecontent = "{!! @$training->content !!}";
    let pageimg = "{!! @$training->avatar !!}";
    var content;
    $(function  () {
        $('#category').select2({
            allowClear: true,
            dropdownParent: $("#corporateform") 
        });
        /** content */
        ClassicEditor.create( document.querySelector( '#content' ) )
        .then( editor => { content = editor } )
        .catch( error => {console.error( error )} );
        setTimeout(() => {
            content.setData(pagecontent);
            $('.oldimg').show();
            $('.oldimg').attr('src', pageimg);
        }, 600);
    });

    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@endpush


