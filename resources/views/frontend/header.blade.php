<div class="header_top"><!--header_top-->
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="contactinfo">
                    <ul class="nav nav-pills">
                        <li><a href="#"><i class="fa fa-phone"></i> +84 0336724296</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i> duong77476@st.vimaru.edu.vn</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="social-icons pull-right">
                    <ul class="nav navbar-nav">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><!--/header_top-->

<div class="header-middle"><!--header-middle-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="logo pull-left">
                    <a href="{{\Illuminate\Support\Facades\URL::to('/trang-chu')}}"><img src="{{url('public/frontend/images/home/logo.png')}}" width="90px" alt="" /></a>
                </div>
                <div class="btn-group pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            VN
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">VN</a></li>
                            <li><a href="#">EN</a></li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            VND
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">VND</a></li>
                            <li><a href="#">Dollar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <!-- Single button -->
                <div class="shop-menu pull-right">
                    @php
                        $customer_id = \Illuminate\Support\Facades\Session::get('customer_id');
                        $shipping_id = \Illuminate\Support\Facades\Session::get('shipping_id');
                        $customer_avatar = \Illuminate\Support\Facades\Session::get('customer_avatar');
                    @endphp

                    @if($customer_id!=null)
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($customer_avatar!=null)
                                <img src="{{\Illuminate\Support\Facades\Session::get('customer_avatar')}}" width="15%" alt="Avatar">
                            @endif
                            {{\Illuminate\Support\Facades\Session::get('customer_name')}} <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @if($customer_id!=null)
                                <li><a href="{{route('account')}}"><i class="fa fa-user"></i> Tài khoản</a></li>
                                <li><a href="#"><i class="fa fa-star"></i> Danh sách yêu thích</a></li>
                            @endif

                            @if($customer_id!=null)
                                <li><a href="{{route('purchase-history')}}"><i class="fa fa-mobile"></i> Lịch sử mua hàng</a></li>
                            @endif

                            @if($customer_id!=null && $shipping_id==null)
                                <li><a href="{{route('checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                            @elseif($customer_id!=null && $shipping_id=!null)
                                <li><a href="{{route('payment')}}"><i class="fa fa-lock"></i> Thanh toán</a></li>
                            @else
                                <li><a href="{{route('login-checkout')}}"><i class="fa fa-lock"></i> Thanh toán</a></li>
                            @endif

                            <li><a href="{{route('gio-hang')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>

                            @if($customer_id!=null)
                                <li><a href="{{route('logout-customer')}}"><i class="fa fa-lock"></i> Đăng xuất</a>
                                </li>

                            @else
                                <li><a href="{{route('login')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                            @endif
                        </ul>
                    </div>
                    @endif
                    <ul class="nav navbar-nav">
                        @if($customer_id==null)
                            <li><a href="{{route('login')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><!--/header-middle-->

<div class="header-bottom"><!--header-bottom-->
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu pull-left">
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        <li><a href="{{\Illuminate\Support\Facades\URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
                        <li class="dropdown"><a href="#">Cửa hàng<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                @foreach($nganh_hangs as $nganh_hang)
                                    <li><a href="{{route('category-by-nganh-hang',['code_nganh_hang'=>$nganh_hang->code])}}">{{$nganh_hang->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                @foreach($post_types as $key=>$post_type)
                                    <li><a href="{{route('danh-muc-bai-viet',['code'=>$post_type->code])}}">{{$post_type->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{route('gio-hang')}}">Giỏ hàng</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
            <style>
                .dropdown {
                    position: relative;
                    display: inline-block;
                }

                .dropdown-product {
                    display: none;
                    position: absolute;
                    background-color: #f9f9f9;
                    min-width: 160px;
                    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                    z-index: 1;
                }
                .dropdown-product a {
                    color: black;
                    padding: 12px 16px;
                    text-decoration: none;
                    display: block;
                }
                .dropdown-product a:hover {background-color: #f1f1f1}

            </style>
            <div class="col-sm-5">
                <form action="{{route('tim-kiem')}}" autocomplete="off" method="post">
                    @csrf
                <div style="width: 100%;padding: 0 10px " class="form-group pull-right">
                    <div class="dropdown">
                        <input style="width: 300px" class="form-control" type="text" name="tu_khoa" id="tu_khoa" placeholder="Tìm kiếm nhanh"/>
                        <div class="dropdown-product" id="search_ajax"></div>
                    </div>
                    <button name="tim_kiem" style="margin-top: 0" class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
{{--                    <input type="submit" style="margin-top: 0;color: black;width: 20px;float: right" value="Tìm kiếm" class="btn btn-primary btn-sm" name="tim_kiem">--}}
                </div>
                </form>
            </div>
        </div>
    </div>
</div><!--/header-bottom-->
