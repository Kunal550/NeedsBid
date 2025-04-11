@php
$route = \Request::route()->getName();
$prefix = request()->segment(2);
@endphp

<div class="profile-img">
    @if (!empty(Auth::user()->profile_image))
    <img src="{{ asset('public/uploads/admin/' . Auth::user()->profile_image) }}" alt="" width="80px" />
    @else
    <img src="{{ asset('public/uploads/admin/noimg.png') }}" alt="" />
    @endif

</div>



<ul>
    <li><a href="{{ route('profile') }}" class="{{ $route == 'profile' ? 'active' : '' }}"><i class="fa fa-pie-chart"></i>
            Dashboard</a></li>
    <li><a href="{{ route('account-details') }}" class="{{ $route == 'account-details' ? 'active' : '' }}"> <i class="fa fa-pencil-square-o"></i> Edit Profile</a></li>

    <li><a href="{{ route('documents.create') }}" class="{{ $route == 'documents.create' ? 'active' : '' }}"> <i class="fa fa-file-invoice"></i> Business Document</a></li>

    <li><a href="{{ route('change-password') }}" class="{{ $route == 'change-password' ? 'active' : '' }}"><i class="fa fa-lock"></i> Change Password</a></li>
    <hr>
    <li><a href="{{ route('project.list') }}" class="{{ $route == 'project.list' ? 'active' : '' }}"><i class="fa-solid fa-file-powerpoint"></i> Post Jobs</a></li>
    <li><a href="{{ route('project.create') }}" class="{{ $route == 'project.create' ? 'active' : '' }}"><i class="fa-solid fa-file-powerpoint"></i> Create Job</a></li>
    <hr>
    <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
</ul>