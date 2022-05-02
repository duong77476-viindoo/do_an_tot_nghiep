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
            <div class="col-sm-12">
                <div class="login-form"><!--login form-->
                    <?php
                    $message = \Illuminate\Support\Facades\Session::get('message');
                    if($message){
                        echo '<span class="text-danger">'.$message.'</span>';
                        \Illuminate\Support\Facades\Session::put('message',null);
                    }
                    ?>
                    <h2>Điền email khôi phục mật khẩu</h2>
                    <form action="{{route('request-pass')}}" method="post">
                        @csrf
                        <input type="text" name="email" placeholder="Nhập email..." />
                        <button type="submit" class="btn btn-default">Xác nhận</button>
                    </form>
                </div><!--/login form-->
            </div>
        </div>
    </div>
</section><!--/form-->

<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



</body>
