@extends('admin.auth.layout.authlayout')
@section('page_title', 'Recover Password')
@section('auth')
    <style>
        .error{
            color: red;
        }
    </style>
    @if(session('error'))
        <script>toastr.error("{{session('error')}}")</script>
    @endif
    @if(session('success'))
        <script>toastr.success("{{session('success')}}")</script>
    @endif
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('admin.login') }}" class="h1"><b>{{ env('APP_SHORT_NAME') }}</b> Admin</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
                <ul>
                    @if($errors->has('password'))<li class="error"><span class="text-left"><small>{{ ucwords($errors->first('password')) }}</small></span></li>@endif
                    @if($errors->has('confirm_password'))<li class="error"><span class="text-left"><small>{{ ucwords($errors->first('confirm_password')) }}</small></span></li>@endif
                </ul>
                <form action="{{ route('admin.password.recovery') }}" method="post" id="passwordrecoveryform">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="recovery_mail" value="{{@$user->email}}">
                    <input type="hidden" name="rowid" value="{{@$user->id}}">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" onclick="loader('show');$('#passwordrecoveryform').submit();" class="btn btn-primary btn-block">Change password</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('admin.login') }}" onclick="gotologin()">Login</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            $('.error').hide();
        }, 4500);
        function gotologin(){
            loader('show');
            setTimeout(() => {
                location.href="{{ route('admin.login') }}";
            }, 400);
        }
    </script>
@endsection