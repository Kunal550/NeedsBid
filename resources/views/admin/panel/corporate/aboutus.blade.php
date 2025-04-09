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
    <?php 
        $errtype = 'aboutus';
        if(@$errors->has('err_type')){
            $errtype = $errors->first('err_type');
        }
    ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">About Us</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                            <li class="breadcrumb-item">Corporate</li>
                            <li class="breadcrumb-item active">About Us</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                    <li class="pt-2 px-3"><h3 class="card-title">{{ucwords(env('APP_SHORT_NAME'))}}</h3></li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $errtype == 'aboutus' ? 'active' : '' }}" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">About US</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $errtype == 'mission' ? 'active' : '' }}" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">OUR MISSION</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $errtype == 'vission' ? 'active' : '' }}" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">OUR VISSION</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $errtype == 'faq' ? 'active' : '' }}" id="custom-tabs-two-settings-tab" data-toggle="pill" href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false">FAQ</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-two-tabContent">
                                    <div class="tab-pane fade {{ $errtype == 'aboutus' ? 'show active' : '' }}" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <form action="{{ route('admin.corporate.about-us') }}" method="post" enctype="multipart/form-data" id="aboutusform">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="page_heading">Page Heading</label>
                                                            <input type="text" name="page_heading" value="{{old('page_heading', @$aboutus->page_heading)}}" id="page_heading" class="form-control" placeholder="Page Heading">
                                                            @if($errors->has('page_heading')) <span class="error"><small>{{ ucwords($errors->first('page_heading')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="image">Page Image</label>
                                                            <input type="file" name="image" id="image" class="form-control">
                                                            @if($errors->has('image')) <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="content">Content</label>
                                                            <textarea name="content" id="content" class="form-control"></textarea>
                                                            @if($errors->has('content')) <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <button type="button" style=" float: right; " class="btn btn-primary" onclick="loader('show');$('#aboutusform').submit();">Save About Us Info</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="rowid" id="rowid" value="{{@$aboutus->id}}">
                                                    <input type="hidden" name="type" value="aboutus">
                                                </form>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Image</label>
                                                <a target="_blank" href="{{@$aboutus->avatar}}"><img src="{{@$aboutus->avatar}}" style=" width: 80%; " alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ $errtype == 'mission' ? 'show active' : '' }}" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <form action="{{ route('admin.corporate.about-us') }}" method="post" enctype="multipart/form-data" id="missionform">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="page_heading">Page Heading</label>
                                                            <input type="text" name="page_heading" value="{{old('page_heading', @$mission->page_heading)}}" id="page_heading" class="form-control" placeholder="Page Heading">
                                                            @if($errors->has('page_heading')) <span class="error"><small>{{ ucwords($errors->first('page_heading')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="image">Page Image</label>
                                                            <input type="file" name="image" id="image" class="form-control">
                                                            @if($errors->has('image')) <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="content">Content</label>
                                                            <textarea name="content" id="mission" class="form-control"></textarea>
                                                            @if($errors->has('content')) <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <button type="button" style=" float: right; " class="btn btn-primary" onclick="loader('show');$('#missionform').submit();">Save our mission</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="rowid" id="rowid" value="{{@$mission->id}}">
                                                    <input type="hidden" name="type" value="mission">
                                                </form>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Image</label>
                                                <a target="_blank" href="{{@$mission->avatar}}"><img src="{{@$mission->avatar}}" style=" width: 80%; " alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ $errtype == 'vission' ? 'show active' : '' }}" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <form action="{{ route('admin.corporate.about-us') }}" method="post" enctype="multipart/form-data" id="vissionform">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="page_heading">Page Heading</label>
                                                            <input type="text" name="page_heading" value="{{old('page_heading', @$vission->page_heading)}}" id="page_heading" class="form-control" placeholder="Page Heading">
                                                            @if($errors->has('page_heading')) <span class="error"><small>{{ ucwords($errors->first('page_heading')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="image">Page Image</label>
                                                            <input type="file" name="image" id="image" class="form-control">
                                                            @if($errors->has('image')) <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="content">Content</label>
                                                            <textarea name="content" id="vission" class="form-control"></textarea>
                                                            @if($errors->has('content')) <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span> @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <button type="button" style=" float: right; " class="btn btn-primary" onclick="loader('show');$('#vissionform').submit();">Save our vission</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="rowid" id="rowid" value="{{@$vission->id}}">
                                                    <input type="hidden" name="type" value="vission">
                                                </form>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Image</label>
                                                <a target="_blank" href="{{@$vission->avatar}}"><img src="{{@$vission->avatar}}" style=" width: 80%; " alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{ $errtype == 'faq' ? 'show active' : '' }}" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                                        @if($errors->has('question.*'))
                                            <ul>
                                            @foreach($errors->get('question.*') as $errors)
                                                @foreach($errors as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            @endforeach
                                            </ul>
                                        @endif
                                        <form action="{{ route('admin.corporate.about-us') }}" method="post" id="faqform">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Question</label>
                                                    <input type="text" name="question[]" id="question" class="form-control" placeholder="Question">
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="">Answer</label>
                                                    <input type="text" name="answer[]" id="answer" class="form-control" placeholder="Answer">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-primary" style=" margin-top: 20%;" onclick="addLine()"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="type" value="faq">
                                            <div class="faqrow mt-3"></div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-primary" onclick="loader('show');$('#faqform').submit();">Save faqs</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>let line_count = 0 ;</script>
@if(@$errors->has('faq_err'))
<script>line_count = "{{@$errors->has('line_count') ? @$errors->first('line_count') : 0}}";</script>
@endif
<script>
    let aboutus_content = "{!! @$aboutus->content !!}";
    let mission_content = "{!! @$mission->content !!}";
    let vission_content = "{!! @$vission->content !!}";    
    let divcount = 0;
    var content, mission, vission;
    $(function  () {
        /** content */
        ClassicEditor.create( document.querySelector( '#content' ) )
        .then( editor => { content = editor } )
        .catch( error => {console.error( error )} );
        /** mission */
        ClassicEditor.create( document.querySelector( '#mission' ) )
        .then( editor => { mission = editor } )
        .catch( error => {console.error( error )} );
        /** vission */
        ClassicEditor.create( document.querySelector( '#vission' ) )
        .then( editor => { vission = editor } )
        .catch( error => {console.error( error )} );
        setTimeout(() => {
            content.setData(aboutus_content);
            mission.setData(mission_content);
            vission.setData(vission_content);
        }, 600);
    });
    if(line_count > 0) {
        for(let i = 0; i < line_count; i++) {
            addLine();
        }
    }
    function addLine(){
        let html = `<div class="row linediv_${divcount} mt-2">
            <div class="col-md-3">
                <input type="text" name="question[]" id="question" class="form-control" placeholder="Question">
            </div>
            <div class="col-md-7">
                <input type="text" name="answer[]" id="answer" class="form-control" placeholder="Answer">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger" onclick="removeLine('${divcount}')"><i class="fa fa-minus"></i></button>
            </div>
        </div>`;
        divcount++;
        $('.faqrow').append(html);
    }
    function removeLine(linecount){
        $('.faqrow').find('.linediv_'+linecount).remove();
    }
    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@endpush


