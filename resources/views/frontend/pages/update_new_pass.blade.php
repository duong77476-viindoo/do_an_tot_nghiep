<head>
    @include('frontend.head')
</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
</header><!--/header-->

<section id="form"><!--form-->
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {!! session()->get('message') !!}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
        <div class="row">
            <div class="col-sm-9">
                <div class="login-form"><!--login form-->
                    <?php
                    $token = $_GET['token'];
                    $email = $_GET['email'];
                    ?>
                    <h2>Điền mật khẩu mới</h2>
                    <form action="{{route('save-new-pass')}}" method="post">
                        @csrf
                        <input type="hidden" name="email" value="{{$email}}" />
                        <input type="hidden" name="token" value="{{$token}}">
                        <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" />
                        <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" />
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
