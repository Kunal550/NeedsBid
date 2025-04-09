@extends('admin.panel.layout.sitelayout')
@section('mytitle', 'Admin | Review')

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
                        <h1 class="m-0">Review</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Review</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" id="reviewtbl">
                            <thead>
                                <tr>
                                    
                                    <th>Content</th>
                                    <th>Rating</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                <tr>
                                    <td>@if(strlen($review->content) > 55){!! substr($review->content, 0, 55) !!} @else {!! $review->content !!} @endif</td>
                                    <td>{{ucwords($review->rating)}}</td>
                                    
                                    <td class="text-center"><span class="{{$review->status == 'A' ? 'text-success' : 'text-warning'}}">{{$review->status == 'A' ? 'Active' : 'Inactive'}}</span></td>
                                    <td class="text-center">
                                        @if($review->status == 'A')
                                        <a href="javascript:void(0);" onclick="changeStatus('{{base64_encode($review->id)}}', 'review_models', 'I')" title="Change {{ucwords($review->heading)}} to Inactive" data-toggle="tooltip"><i class="text-success fas fa-toggle-on"></i></a>
                                        @else
                                        <a href="javascript:void(0);" onclick="changeStatus('{{base64_encode($review->id)}}', 'review_models', 'A')" title="Change {{ucwords($review->heading)}} to Active" data-toggle="tooltip"><i class="text-danger fas fa-toggle-off"></i></a>
                                        @endif
                                        &nbsp;
                                        <a href="javascript:void(0);" onclick="edit('{{base64_encode($review->id)}}')" title="Edit {{ucwords($review->heading)}}" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                        &nbsp;
                                        <a href="javascript:void(0);" onclick="changeStatus('{{base64_encode($review->id)}}', 'review_models', 'D')" title="Delete {{ucwords($review->heading)}}" data-toggle="tooltip"><i class="text-danger fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>    
                        {{ $reviews->appends(Request::except('page'))->links("pagination::bootstrap-5") }}                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Services <span id="modaltype">Add</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#reviewModal').modal('hide');">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.review')}}" method="post" enctype="multipart/form-data" id="reviewform">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Content</label>
                                    <textarea name="content" id="content" class="form-control"></textarea>
                                    @if($errors->has('content')) <span class="error"><small>{{ ucwords($errors->first('content')) }}</small></span> @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="rating">Rating <span class="req">*</span></label>
                                    <input type="number" name="rating" id="rating" min="1" max="5" class="form-control" placeholder="Rating" required>
                                    @if($errors->has('rating')) <span class="error"><small>{{ ucwords($errors->first('rating')) }}</small></span> @endif
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="rowid" id="rowid">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#reviewModal').modal('hide');">Close</button>
                    <button type="button" id="reviewModalbtn" onclick="loader('show');$('#reviewform').submit();" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    var content;
    $(function  () {
        ClassicEditor.create( document.querySelector( '#content' ) )
        .then( editor => { content = editor } )
        .catch( error => {console.error( error )} );

        $('#reviewtbl').dataTable({
            "bPaginate": false,
            "bInfo" : false,
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '+ Add Review',
                    action: function ( e, dt, node, config ) {
                        resetform();
                        $('#reviewModal').modal('show');
                    }
                }
            ],
            'columnDefs': [{
               'targets': [2, 3], 
               'orderable': false, 
            }]
        });
    });
    function edit(rowid){
        let url = "{{route('admin.review.get')}}" + '/' + rowid;
        $.get(url, function(res){
            if(res.code == '200'){
                resetform();
                putvalue(res.data);
                $('#reviewModal').modal('show');
            }
        });
    }
    function resetform(){
        $('.oldimg').hide();
        content.setData('');
        $('#reviewModal').find('#editimg').attr('src', '');
        $('#reviewModal').find('#editimg').parent('a').attr('href', '');
        $('#reviewform')[0].reset();
    }
    function putvalue(res){
        $('#reviewModal').find('#rating').val(res.rating);
        content.setData(res.content);
        $('.oldimg').show();
        $('#reviewModal').find('#editimg').attr('src', res.avatar);
        $('#reviewModal').find('#editimg').parent('a').attr('href', res.avatar);
        $('#reviewModal').find('#rowid').val(res.id);
    }
    function changeStatus(rowid, tbl, status){
        $.confirm({
            title: 'Confirm!',
            content: 'Do you want to change the status?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                ok: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    action: function(){
                        $.ajax({
                            url : "{{route('admin.status.change', ['type' => 'review'])}}",
                            data: {'_token': '{{csrf_token()}}', 'rowid': rowid, 'status': status, 'tbl': tbl},
                            type: 'POST',
                            success: function(res){
                                if(res.code == '200'){
                                    $.alert(res.msg);
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            },
                            error: function(err){
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
    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@if(@$errors->has('review_err'))
    @if(@$errors->has('review_err_rowid'))
    <script>
        let rowid = "{{@$errors->first('review_err_rowid')}}";
        edit(rowid);
    </script>
    @else
    <script>$('#reviewModal').modal('show');</script>
    @endif
@endif
@endpush


