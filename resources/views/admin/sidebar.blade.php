<?php
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('public/backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('public/backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{$admin}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                @hasRole(['Admin'])
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Quản lý hệ thống
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('view-admin-users')}}" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Người dùng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasRole
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh mục
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('all-category')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Loại phân loại</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-category-product')}}" class="nav-link">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>Phân loại sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-brand')}}" class="nav-link">
                                <i class="fas fa-apple-alt nav-icon"></i>
                                <p>Thương hiệu sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-slider')}}" class="nav-link">
                                <i class="fas fa-image nav-icon"></i>
                                <p>Slider-Banner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-product')}}" class="nav-link">
                                <i class="fas fa-mobile-alt nav-icon"></i>
                                <p>Sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-comment')}}" class="nav-link">
                                <i class="fas fa-comment nav-icon"></i>
                                <p>Bình luận</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-coupon')}}" class="nav-link">
                                <i class="fas fa-gift nav-icon"></i>
                                <p>Mã giảm giá</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-video')}}" class="nav-link">
                                <i class="fas fa-video nav-icon"></i>
                                <p>Video</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Quản lý bán hàng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('all-customer-order')}}" class="nav-link">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Hóa đơn bán hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-brand')}}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>bla bla</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fa fa-truck"></i>
                        <p>
                            Quản lý vận chuyển
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('fee-ship')}}" class="nav-link">
                                <i class="fa fa-money-bill-alt nav-icon"></i>
                                <p>Phí vận chuyển</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fa fa-newspaper"></i>
                        <p>
                            Quản lý bài viết
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('all-post-type')}}" class="nav-link">
                                <i class="fa fa-book nav-icon"></i>
                                <p>Danh mục bài viết</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-post')}}" class="nav-link">
                                <i class="fa fa-book-open nav-icon"></i>
                                <p>Bài viết</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Marketing</li>
                <li class="nav-item">
                    <a href="{{route('sendportal.dashboard')}}" class="nav-link">
                        <i class="nav-icon fa fa-mail-bulk"></i>
                        <p>
                            Email Marketing
                            <span class="badge badge-info right">Test</span>
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

@section('pagescript')
    {{--Script để mà khi click vào một mục ở sidebar--}}
    <script type="text/javascript">
        $(document).ready(function (){
            $('.nav-choose').click(function (){
                var menu_open = $(this).closest("li").attr("class");
                if(menu_open==="nav-item")
                    $(this).addClass('active');
                else{
                    $(this).removeClass('active');
                }
            })
            $(document).on('blur','.nav-choose',function (){
                $(this).removeClass('active');
            })

        })
    </script>
@endsection
