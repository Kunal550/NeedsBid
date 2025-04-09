@extends('admin.auth.layout.authlayout')
@section('page_title', 'Forgot Password')
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
        <p class="login-box-msg">You are one step away from forgot password.</p>
        <ul>
          @if($errors->has('forgot_mail'))<li class="error"><span class="text-left"><small>{{ ucwords($errors->first('forgot_mail')) }}</small></span></li>@endif
        </ul>
        <form action="{{ route('admin.forgot.password') }}" method="post" id="forgotpasswordform">
          @csrf
          <div class="input-group mb-3">
            <input type="email" name="forgot_mail" class="form-control" placeholder="Forgot Mail">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" onclick="loader('show');$('#forgotpasswordform').submit();" class="btn btn-primary btn-block">Send Mail</button>
            </div>
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="javascript:void(0);" onclick="gotologin()">Login</a>
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