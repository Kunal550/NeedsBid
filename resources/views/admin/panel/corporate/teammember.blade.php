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
                        <h1 class="m-0">Team Members</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.login') }}">Home</a></li>
                            <li class="breadcrumb-item">Corporate</li>
                            <li class="breadcrumb-item active">Team Members</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row table-resposive">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" id="membertbl">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Designation</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teammembers as $t)
                                <tr>
                                    <td>{{ucwords($t->member_name)}}</td>
                                    <td>{{ucwords($t->designation)}}</td>
                                    <td class="text-center"><a target="_blank" href="{{$t->avatar}}"><img src="{{$t->avatar}}" class="img" alt=""></a></td>
                                    <td class="text-center"><span class="{{$t->status == 'A' ? 'text-success' : 'text-warning'}}">{{$t->status == 'A' ? 'Active' : 'Inactive'}}</span></td>
                                    <td class="text-center">
                                        @if($t->status == 'A')
                                            <a href="javascript:void(0);" onclick="changeStatus('{{base64_encode($t->id)}}', 'teammembers', 'I')" title="Change {{ucwords($t->member_name)}} to Inactive" data-toggle="tooltip"><i class="text-success fas fa-toggle-on"></i></a>
                                        @else
                                            <a href="javascript:void(0);" onclick="changeStatus('{{base64_encode($t->id)}}', 'teammembers', 'A')" title="Change {{ucwords($t->member_name)}} to Active" data-toggle="tooltip"><i class="text-danger fas fa-toggle-off"></i></a>
                                        @endif
                                        &nbsp;
                                        <a href="javascript:void(0);" onclick="edit('{{base64_encode($t->id)}}')" title="Edit {{ucwords($t->member_name)}}" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0);" onclick="changeStatus('{{base64_encode($t->id)}}', 'teammembers', 'D')" title="Delete {{ucwords($t->member_name)}}" data-toggle="tooltip"><i class="text-danger fas fa-trash"></i></a>
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
    <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberModalLabel">Members Info <span id="modaltype">Add</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#memberModal').modal('hide');">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" id="memberform">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="member_name">Member Name <span class="req">*</span></label>
                                    <input type="text" name="member_name" id="member_name" class="form-control" placeholder="Designation">
                                    @if($errors->has('member_name')) <span class="error"><small>{{ ucwords($errors->first('member_name')) }}</small></span> @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    @if($errors->has('image')) <span class="error"><small>{{ ucwords($errors->first('image')) }}</small></span> @endif
                                </div>
                                <div class="col-md-2 oldimg">
                                    <a href="" target="_blank"><img src="" class="img" id="editimg" alt="" style=" margin-top: 35%; "></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Designation <span class="req">*</span></label>
                                    <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation">
                                    @if($errors->has('designation')) <span class="error"><small>{{ ucwords($errors->first('designation')) }}</small></span> @endif
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="rowid" id="rowid">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#memberModal').modal('hide');">Close</button>
                    <button type="button" id="memberModalbtn" onclick="loader('show');$('#memberform').submit();" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    $(function  () {
        $('#membertbl').dataTable({
            "bPaginate": false,
            "bInfo" : false,
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '+ Add Team Members',
                    action: function ( e, dt, node, config ) {
                        resetform();
                        $('#memberModal').modal('show');
                    }
                }
            ],
            'columnDefs': [{
               'targets': [2, 3, 4], 
               'orderable': false, 
            }]
        });
    });
    function edit(rowid){
        let url = "{{route('admin.corporate.getsinglerow', ['type'=>'teammembers'])}}" + '/' + rowid;
        $.get(url, function(res){
            if(res.code == '200'){
                resetform();
                putvalue(res.data);
                $('#memberModal').modal('show');
            }
        });
    }
    function resetform(){
        $('.oldimg').hide();
        $('#memberModal').find('#member_name').val('');
        $('#memberModal').find('#designation').val('');
        $('#memberModal').find('#editimg').attr('src', '');
        $('#memberform')[0].reset();
    }
    function putvalue(res){
        $('#memberModal').find('#heading').val(res.heading);
        $('.oldimg').show();
        $('#memberModal').find('#member_name').val(res.member_name);
        $('#memberModal').find('#designation').val(res.designation);
        $('#memberModal').find('#editimg').attr('src', res.avatar);
        $('#memberModal').find('#rowid').val(res.id);
    }
    function changeStatus(rowid, tbl, status){
        $.confirm({
            title: 'Confirm!',
            content: 'Do you want to change the status?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                ok: {
                    text: 'Change it!',
                    btnClass: 'btn-red',
                    action: function(){
                        $.ajax({
                            url : "{{route('admin.status.change', ['type' => 'technology'])}}",
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
                    text: 'Cancel it!',
                }
            }
        });
    }
    setTimeout(() => {
        $('.error').hide();
    }, 4500);
</script>
@if(@$errors->has('teammember_err'))
    @if(@$errors->has('teammember_err_rowid'))
    <script>
        let rowid = "{{@$errors->first('teammember_err_rowid')}}";
        edit(rowid);
    </script>
    @else
    <script>$('#memberModal').modal('show');</script>
    @endif
@endif
@endpush


