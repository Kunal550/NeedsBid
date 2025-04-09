<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ Request::is('admin/dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.login') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

                <!-- Customer Pages -->
                <li class="nav-item {{ Request::is('admin/users/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.users.list') }}"
                        class="nav-link {{ Request::is('admin/users/list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Users</p>
                    </a>
                </li>

                <!-- Role Management -->

                <li class="nav-item {{ Request::is('admin/roles') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.roles.list') }}" class="nav-link {{ Request::is('admin/roles/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Role</p>
                    </a>
                </li>

                <!-- Permission Management -->
                <li class="nav-item {{ Request::is('admin/permissions') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.permissions.list') }}"
                        class="nav-link {{ Request::is('admin/permissions/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Permission</p>
                    </a>
                </li>


                <li class="nav-item {{ Request::is('admin/role-permissions') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.role-permissions.list') }}"
                        class="nav-link {{ Request::is('admin/role-permissions/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hat-cowboy"></i>
                        <p>Role Permission</p>
                    </a>
                </li>


                <!-- Banner Management -->

                <li class="nav-item {{ Request::is('admin/banner') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.banner.banner') }}"
                        class="nav-link {{ Request::is('admin/banner/*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-images"></i>
                        <p>Banner</p>
                    </a>
                </li>

                <!-- CMS Pages -->
                <li class="nav-item {{ Request::is('admin/cms/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0);" class="nav-link {{ Request::is('admin/cms/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>CMS <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.cms.pages.list') }}" class="nav-link {{ Request::is('admin/cms/pages/list') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.cms.how_it_work.list') }}"
                                class="nav-link {{ Request::is('admin/cms/how_it_work/list') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>How It Works</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.cms.testimonial.list') }}"
                                class="nav-link {{ Request::is('admin/cms/testimonial/list') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Testimonial</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.cms.blog.list') }}"
                                class="nav-link {{ Request::is('admin/cms/blog/list') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Blog</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.cms.faq.list') }}"
                                class="nav-link {{ Request::is('admin/cms/faq/list') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>FAQ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.cms.feedback.list') }}"
                                class="nav-link {{ Request::is('admin/cms/feedback/list') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer Feedback</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>


                <li class="nav-item {{ Request::is('admin/projects/*') ? 'menu-open' : '' }}">
                    <a href="javascript:void(0);"
                        class="nav-link {{ Request::is('admin/projects/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Projects<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.project-category.list') }}"
                                class="nav-link {{ Request::is('admin/project-category/list') ? 'active' : '' }}">
                                <i class="fas fa-project-diagram nav-icon"></i>
                                <p>Project Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.projects.project') }}"
                                class="nav-link {{ Request::is('admin/projects/project') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Projects</p>
                            </a>
                        </li>

                    </ul>
                </li>



                <!-- Contractor Pages -->
                <li class="nav-item {{ Request::is('admin/contractor/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.contractor.list') }}"
                        class="nav-link {{ Request::is('admin/contractor.list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Contractor Trade</p>
                    </a>
                </li>

                <!-- Construction Pages -->
                <li class="nav-item {{ Request::is('admin/constructor-type/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.constructor-type.list') }}"
                        class="nav-link {{ Request::is('admin.constructor-type.list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>Construction Type</p>
                    </a>
                </li>


                <!-- State Pages -->

                <li class="nav-item {{ Request::is('admin/states/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.states.list') }}"
                        class="nav-link {{ Request::is('admin.states.list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>States</p>
                    </a>
                </li>


                <li class="nav-item {{ Request::is('admin/content/list') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.content.list') }}"
                        class="nav-link {{ Request::is('admin/content/list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Content</p>
                    </a>
                </li>


                <!-- Review System -->

                {{-- <li class="nav-item {{ Request::is('admin/review') ? 'menu-open' : '' }}">
                <a href="{{ route('admin.review') }}"
                    class="nav-link {{ Request::is('admin/review') ? 'active' : '' }}">
                    <i class="nav-icon far fa-plus-square"></i>
                    <p>Review</p>
                </a>
                </li> --}}
                <!-- END -->


                <!-- settings  -->
                <li class="nav-item {{ Request::is('admin/setting') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.setting') }}"
                        class="nav-link {{ Request::is('admin/setting') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>




                <!-- logout  -->
                <li class="nav-item {{ Request::is('admin.logout') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.logout') }}"
                        class="nav-link {{ Request::is('admin/logout') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>Log Out</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>