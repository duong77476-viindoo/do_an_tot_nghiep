<head>
    @include('frontend.head')
</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
</header><!--/header-->

<section id="cart_items">
    <div class="container">
        <div class="review-payment">
            <h2>Cảm ơn bạn đã đặt hàng, chúng tôi sẽ liên hệ với bạn sớm nhất</h2>
        </div>
    </div>
</section> <!--/#cart_items-->


<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



<script src="{{url('public/frontend/js/jquery.js')}}js/jquery.js"></script>
<script src="{{url('public/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{url('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{url('public/frontend/js/main.js')}}"></script>
</body>
