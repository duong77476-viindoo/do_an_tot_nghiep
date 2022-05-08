<head>
    @include('frontend.head')

</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
    <style type="text/css">
        .card{
            margin: auto;
            width: 38%;
            max-width:600px;
            padding: 4vh 0;
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-top: 3px solid rgb(252, 103, 49);
            border-bottom: 3px solid rgb(252, 103, 49);
            border-left: none;
            border-right: none;
        }
        @media(max-width:768px){
            .card{
                width: 90%;
            }
        }
        .title{
            color: rgb(252, 103, 49);
            font-weight: 600;
            margin-bottom: 2vh;
            padding: 0 8%;
            font-size: initial;
        }
        #details{
            font-weight: 400;
        }
        .info{
            padding: 5% 8%;
        }
        .info .col-md-5{
            padding: 0;
        }
        #heading{
            color: grey;
            line-height: 6vh;
        }
        .pricing{
            background-color: #ddd3;
            padding: 2vh 8%;
            font-weight: 400;
            line-height: 2.5;
        }
        .pricing .col-md-3{
            padding: 0;
        }
        .total{
            padding: 2vh 8%;
            color: rgb(252, 103, 49);
            font-weight: bold;
        }
        .total .col-md-3{
            padding: 0;
        }
        .footer{
            padding: 0 8%;
            font-size: x-small;
            color: black;
        }
        .footer img{
            height: 5vh;
            opacity: 0.2;
        }
        .footer a{
            color: rgb(252, 103, 49);
        }
        .footer .col-md-10, .col-md-2{
            display: flex;
            padding: 3vh 0 0;
            align-items: center;
        }
        .footer .row{
            margin: 0;
        }
        #progressbar {
            margin-bottom: 3vh;
            overflow: hidden;
            color: rgb(252, 103, 49);
            padding-left: 0px;
            margin-top: 3vh
        }

        #progressbar li {
            list-style-type: none;
            font-size: x-small;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400;
            color: rgb(160, 159, 159);
        }

        #progressbar #step1:before {
            content: "";
            color: rgb(252, 103, 49);
            width: 5px;
            height: 5px;
            margin-left: 0px !important;
            /* padding-left: 11px !important */
        }

        #progressbar #step2:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-left: 32%;
        }

        #progressbar #step3:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 32% ;
            /* padding-right: 11px !important */
        }

        #progressbar #step4:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 0px !important;
            /* padding-right: 11px !important */
        }

        #progressbar li:before {
            line-height: 29px;
            display: block;
            font-size: 12px;
            background: #ddd;
            border-radius: 50%;
            margin: auto;
            z-index: -1;
            margin-bottom: 1vh;
        }

        #progressbar li:after {
            content: '';
            height: 2px;
            background: #ddd;
            position: absolute;
            left: 0%;
            right: 0%;
            margin-bottom: 2vh;
            top: 1px;
            z-index: 1;
        }
        .progress-track{
            padding: 0 8%;
        }
        #progressbar li:nth-child(2):after {
            margin-right: auto;
        }

        #progressbar li:nth-child(1):after {
            margin: auto;
        }

        #progressbar li:nth-child(3):after {
            float: left;
            width: 68%;
        }
        #progressbar li:nth-child(4):after {
            margin-left: auto;
            width: 132%;
        }

        #progressbar  li.active{
            color: black;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: rgb(252, 103, 49);
        }
    </style>

</header><!--/header-->

<div class="card">
    <div class="title">Hóa đơn</div>
    <div class="info">
        <div class="row">
            <div class="col-md-7">
                <span id="heading">Ngày</span><br>
                <span id="details">{{$order->order_date}}</span>
            </div>
            <div class="col-md-5 pull-right">
                <span id="heading">Hóa Đơn Số</span><br>
                <span id="details">{{$order->id}}</span>
            </div>
        </div>
    </div>
    <div class="" style="margin-left: 50px">
        @php
            $subtotal = 0;
        @endphp
        @foreach($order_detail as $key => $item)
            <div class="row">
                <div class="col-md-6" style="padding: 0">
                    <span id="name">{{$item->product->name}}</span>
                </div>
                <div class="col-md-3" style="padding: 0">
                    <span id="quantity">{{$item->so_luong}}</span>
                </div>
                <div class="col-md-3" style="padding: 0">
                    <span id="price">{{number_format($item->product_price,0,',','.')}} VND</span>
                </div>
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-9" style="padding: 0">
                <span id="name">Phí ship</span>
            </div>
            <div class="col-md-3" style="padding: 0">
                <span id="price">{{number_format($order->fee_ship,0,'','.')}} VND</span>
            </div>
        </div>
    </div>
    <div class="total">
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">{{number_format($order->tong_tien,0,',','.')}} VND</div>
        </div>
    </div>
    <div class="tracking">
        <div class="title">Theo dõi đơn hàng</div>
    </div>
    <div class="progress-track">
        <ul id="progressbar">
            @if($order->trang_thai=="Đang chờ xử lý")
                <li class="step0 active" id="step1">Đã đặt</li>
                <li class="step0 text-center" id="step2">Đã xác nhận</li>
                <li class="step0 text-right" id="step3">Đang giao</li>
                <li class="step0 text-right" id="step4">Đã giao</li>
            @elseif($order->trang_thai=="Đang xử lý")
                <li class="step0 active" id="step1">Đã đặt</li>
                <li class="step0 active text-center" id="step2">Đã xác nhận</li>
                <li class="step0 text-right" id="step3">Đang giao</li>
                <li class="step0 text-right" id="step4">Đã giao</li>
            @elseif($order->trang_thai=="Đang giao hàng")
                <li class="step0 active" id="step1">Đã đặt</li>
                <li class="step0 active text-center" id="step2">Đã xác nhận</li>
                <li class="step0 active text-right" id="step3">Đang giao</li>
                <li class="step0 text-right" id="step4">Đã giao</li>
            @elseif($order->trang_thai=="Đã giao hàng")
                <li class="step0 active" id="step1">Đã đặt</li>
                <li class="step0 active text-center" id="step2">Đã xác nhận</li>
                <li class="step0 active text-right" id="step3">Đang giao</li>
                <li class="step0 active text-right" id="step4">Đã giao</li>
            @else
                <li><h2 class="text-center">ĐÃ HỦY</h2></li>
            @endif
        </ul>
    </div>


    <div class="footer">
        <div class="row">
            <div class="col-md-2"><img class="img-fluid" src="{{url('public/frontend/images/home/logo.png')}}"></div>
            <div class="col-md-8">Bạn cần hỗ trợ &nbsp;<a> hãy liên lạc với chúng tôi</a></div>
            <div class="col-md-2" style="padding: 0"><a class="" href="{{route('download-order',['id'=>$order->id])}}" target="_blank"> Download Hóa Đơn</a></div>
        </div>


    </div>
</div>
<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



</body>
