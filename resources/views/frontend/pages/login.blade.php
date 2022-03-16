<head>
    @include('frontend.head')
</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
</header><!--/header-->

<section id="form"><!--form-->
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <?php
                    $message = \Illuminate\Support\Facades\Session::get('message');
                    if($message){
                        echo '<span class="text-danger">'.$message.'</span>';
                        \Illuminate\Support\Facades\Session::put('message',null);
                    }
                    ?>
                    <h2>Đăng nhập tài khoản</h2>
                    <form action="{{route('login-customer')}}" method="post">
                        @csrf
                        <input type="text" name="email" placeholder="Tài khoản" />
                        <input type="password" name="password" placeholder="Mật khẩu" />
                        <span>
								<input type="checkbox" class="checkbox">
								Ghi nhớ đăng nhập
							</span>
                        <button type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng ký mới!</h2>
                    <form action="{{route('add-customer')}}" method="post">
                        @csrf
                        <input name="name" type="text" placeholder="Họ tên"/>
                        <input name="email" type="email" placeholder="Email"/>
                        <input name="password" type="password" placeholder="Password"/>
                        <input name="phone" type="text" placeholder="Điện thoại"/>
                        <input name="address" type="text" placeholder="Địa chỉ"/>
                        <button type="submit" class="btn btn-default">Đăng ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->

<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



<script src="{{url('public/frontend/js/jquery.js')}}js/jquery.js"></script>
<script src="{{url('public/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{url('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{url('public/frontend/js/main.js')}}"></script>
</body>
