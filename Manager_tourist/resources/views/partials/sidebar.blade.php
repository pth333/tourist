    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="nav-profile-image">
                        <img src="{{ asset('images/faces/face14.jpg')}}" alt="profile">
                        <span class="login-status online"></span>
                        <!--change to offline or busy as needed-->
                    </div>
                    <div class="nav-profile-text d-flex flex-column">
                        <span class="font-weight-bold mb-2">{{ Auth::user()->name}}</span>
                        <span class="text-secondary text-small">Project Manager</span>
                    </div>
                    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('dashboard')}}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index')}}">
                    <span class="menu-title">Quản lý danh mục</span>
                    <i class="mdi mdi-format-list-bulleted menu-icon"></i>

                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('destination.index')}}">
                    <span class="menu-title">Quản lý địa điểm</span>
                    <i class="mdi mdi-google-maps menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('post.index')}}">
                    <span class="menu-title">Quản lý bài viết</span>
                    <i class="mdi mdi-content-save menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('comment.index')}}">
                    <span class="menu-title">Quản lý bình luận</span>
                    <i class="mdi mdi-ticket-account menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaction.cus')}}">
                    <span class="menu-title">Quản lý giao dịch</span>
                    <i class="mdi mdi-ticket-account menu-icon"></i>
                </a>
            </li>

            <ul class="navbar-nav">
                <li class="nav-item custom-nav-item">
                    <div class="nav-link-wrapper">
                        <a class="nav-link custom-nav-link">
                            <span class="menu-title">Tour</span>
                        </a>
                        <i class="mdi mdi-chevron-down custom-chevron-icon" data-toggle="collapse" data-target="#submenu-tour" aria-expanded="false" aria-controls="submenu-tour"></i>
                    </div>
                </li>

                <div class="collapse" id="submenu-tour">
                    <ul class="navbar-nav ml-3">
                        <li class="nav-item-native">
                            <a class="nav-link" href="{{ route('tour.index')}}">
                                <span class="menu-title">Quản lý tour</span>
                            </a>
                        </li>
                        <li class="nav-item-native">
                            <a class="nav-link" href="{{ route('schedule.tour')}}">
                                <span class="menu-title">Quản lý lịch trình</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item custom-nav-item">
                    <div class="nav-link-wrapper">
                        <a class="nav-link custom-nav-link">
                            <span class="menu-title">Cài đặt</span>
                        </a>
                        <i class="mdi mdi-chevron-down custom-chevron-icon" data-toggle="collapse" data-target="#submenu-setting" aria-expanded="false" aria-controls="submenu-tour"></i>
                    </div>
                </li>

                <div class="collapse" id="submenu-setting">
                    <ul class="navbar-nav ml-3">
                        <li class="nav-item-native">
                            <a class="nav-link" href="{{ route('slider.index')}}">
                                <span class="menu-title">Quản lý slider</span>
                            </a>
                        </li>
                        <li class="nav-item-native">
                            <a class="nav-link" href="{{ route('setting.index')}}">
                                <span class="menu-title">Quản lý setting</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item custom-nav-item">
                    <div class="nav-link-wrapper">
                        <a class="nav-link custom-nav-link">
                            <span class="menu-title">Admin</span>
                        </a>
                        <i class="mdi mdi-chevron-down custom-chevron-icon" data-toggle="collapse" data-target="#submenu-admin" aria-expanded="false" aria-controls="submenu-tour"></i>
                    </div>
                </li>

                <div class="collapse" id="submenu-admin">
                    <ul class="navbar-nav ml-3">
                        <li class="nav-item-native">
                            <a class="nav-link" href="{{ route('user.index')}}">
                                <span class="menu-title">Quản lý nhân viên</span>
                            </a>
                        </li>
                        <li class="nav-item-native">
                            <a class="nav-link" href="{{ route('role.index')}}">
                                <span class="menu-title">Vai Trò</span>
                            </a>
                        </li>
                        <li class="nav-item-native">
                            <a class="nav-link" href="{{ route('permission.create')}}">
                                <span class="menu-title">Tạo thêm quyền</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>

        </ul>
    </nav>

    <style>
        .nav-link-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-link-wrapper .nav-link {
            flex-grow: 1;
            padding-right: 10px;
        }

        .custom-chevron-icon {
            cursor: pointer;
            padding-left: 10px;
            /* Đảm bảo có khoảng cách giữa tiêu đề và mũi tên */
        }

        .nav-item-native {
            padding-left: 50px;
        }
    </style>
