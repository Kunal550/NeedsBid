  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('admin.login') }}" class="nav-link">Home</a>
          </li>
      </ul>
      <ul class="navbar-nav ml-auto">
          <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{ asset('public/uploads/admin/' . Auth::user()->profile_image) }}" class="user-image"
                      alt="User Image">
              </a>
              <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                      <img src="{{ asset('public/uploads/admin/' . Auth::user()->profile_image) }}" class="img-circle"
                          alt="User Image">

                      <p>
                          {{ Auth::user()->name }}
                      </p>
                  </li>
                  <!-- Menu Body -->

                  <!-- Menu Footer-->
                  <li class="user-footer">
                      <div class="pull-left">
                          <a href="{{ route('admin.profilesetup') }}" class="btn btn-default btn-flat">Profile</a>
                      </div>
                      <div class="pull-right">
                          <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Log Out</a>
                      </div>
                  </li>
              </ul>
          </li>
          <!-- right side bar  -->
          <li class="nav-item custom-theme">
              <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="javascript:void(0);"
                  role="button">
                  <i class="fas fa-th-large"></i>
              </a>
          </li>
      </ul>
  </nav>
  <!-- /.navbar -->
<style>
    .custom-theme{
        display: none;
    }
    .dataTables_length{
        float: left;
    }
    div.dataTables_wrapper div.dataTables_filter input{
        outline: none !important;
        padding: 1px 5px;
    }
    label{
        display: inline-block;
        font-size: 13px;
        font-weight: 600 !important;
    }
    .images-box{
        position: relative;
        margin-bottom: 20px;
        border-radius: 5px;
        overflow: hidden;
    }
    .images-box img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .images-box .del-gallery-img{
        position: absolute;
        right: 8px;
        top: 4px;
        font-size: 12px;
    }
    .image-showbanner {
        width: 100%;
        height: 150px;
        margin-top: 15px;
        display: block;
        border-radius: 5px;
        overflow: hidden;
    }
    .image-showbanner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: #000;
    }
    .user.user-menu {
    margin-right: 22px;
}
.dropdown-toggle{
    display: flex; align-items: center;
}
.dropdown-toggle::after{
    border-top: 0.3em solid #000;
}
.navbar-nav>.user-menu .user-image{
    margin-right: 0;
}

.navbar-nav>.user-menu>.dropdown-menu>li.user-header{
    height: auto !important;
}

.navbar-nav>.user-menu>.dropdown-menu>li.user-header>p {
    z-index: 5;
    font-size: 17px;
    margin-top: 5px;
    margin-bottom: 0;
}
.navbar-nav>.user-menu>.dropdown-menu>.user-footer{
    background-color: ;
}
.navbar-nav>.user-menu>.dropdown-menu>.user-footer {
    background-color: #333a40;
    padding: 10px;
}
.navbar-nav>.user-menu>.dropdown-menu>.user-footer .pull-left a, .navbar-nav>.user-menu>.dropdown-menu>.user-footer .pull-right a{
    display: block;
    width: 100%;
    text-align: left;
    color: #fff;
    font-size: 14px;
}
.navbar-nav>.user-menu>.dropdown-menu>.user-footer .pull-left a:hover, .navbar-nav>.user-menu>.dropdown-menu>.user-footer .pull-right a:hover{
    color: #000;
}

</style>