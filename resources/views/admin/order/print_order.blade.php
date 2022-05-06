<html>
<head>
    <title>Hóa đơn số #{{$order->id}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ltrim(public_path('bootstrap-3.3.7/dist/css/bootstrap.css'), '/')}}">
    <link rel="stylesheet" href="{{url('public/bootstrap-3.3.7/dist/css/bootstrap.css')}}">
    <style>
        body{
            font-family: "DejaVu Sans", sans-serif;
        }
        .receipt-content .logo a:hover {
            text-decoration: none;
            color: #7793C4;
        }

        .receipt-content .invoice-wrapper {
            background: #FFF;
            border: 1px solid #CDD3E2;
            box-shadow: 0px 0px 1px #CCC;
            padding: 40px 40px 60px;
            margin-top: 40px;
            border-radius: 4px;
        }

        .receipt-content .invoice-wrapper .payment-details span {
            color: #A9B0BB;
            display: block;
        }
        .receipt-content .invoice-wrapper .payment-details a {
            display: inline-block;
            margin-top: 5px;
        }

        .receipt-content .invoice-wrapper .line-items .print a {
            display: inline-block;
            border: 1px solid #9CB5D6;
            padding: 13px 13px;
            border-radius: 5px;
            color: #708DC0;
            font-size: 13px;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .line-items .print a:hover {
            text-decoration: none;
            border-color: #333;
            color: #333;
        }

        .receipt-content {

        }
        @media (min-width: 1200px) {
            .receipt-content .container {width: 900px; }
        }

        .receipt-content .logo {
            text-align: center;
            margin-top: 50px;
        }

        .receipt-content .logo a {
            font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
            font-size: 36px;
            letter-spacing: .1px;
            color: #555;
            font-weight: 300;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .intro {
            line-height: 25px;
            color: #444;
        }

        .receipt-content .invoice-wrapper .payment-info {
            margin-top: 25px;
            padding-top: 15px;
        }

        .receipt-content .invoice-wrapper .payment-info span {
            color: #A9B0BB;
        }

        .receipt-content .invoice-wrapper .payment-info strong {
            display: block;
            color: #444;
            margin-top: 3px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-info .text-right {
                text-align: left;
                margin-top: 20px; }
        }
        .receipt-content .invoice-wrapper .payment-details {
            border-top: 2px solid #EBECEE;
            margin-top: 30px;
            padding-top: 20px;
            line-height: 22px;
        }


        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-details .text-right {
                text-align: left;
                margin-top: 20px; }
        }
        .receipt-content .invoice-wrapper .line-items {
            margin-top: 40px;
        }
        .receipt-content .invoice-wrapper .line-items .headers {
            color: #A9B0BB;
            font-size: 13px;
            letter-spacing: .3px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 4px;
        }
        .receipt-content .invoice-wrapper .line-items .items {
            margin-top: 8px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 8px;
        }
        .receipt-content .invoice-wrapper .line-items .items .item {
            padding: 10px 0;
            color: #696969;
            font-size: 15px;
        }
        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item {
                font-size: 13px; }
        }
        .receipt-content .invoice-wrapper .line-items .items .item .amount {
            letter-spacing: 0.1px;
            color: #84868A;
            font-size: 16px;
        }
        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item .amount {
                font-size: 13px; }
        }

        .receipt-content .invoice-wrapper .line-items .total {
            margin-top: 30px;
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes {
            float: left;
            width: 40%;
            text-align: left;
            font-size: 13px;
            color: #7A7A7A;
            line-height: 20px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .total .extra-notes {
                width: 100%;
                margin-bottom: 30px;
                float: none; }
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
            display: block;
            margin-bottom: 5px;
            color: #454545;
        }

        .receipt-content .invoice-wrapper .line-items .total .field {
            margin-bottom: 2px;
            font-size: 16px;
            color: #555;
        }

        .receipt-content .invoice-wrapper .line-items .total .field.grand-total {
            margin-top: 10px;
            font-size: 16px;
            font-weight: normal;
        }

        .receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
            margin-top: 4px;
            color: #20A720;
            font-size: 16px;
        }

        .receipt-content .invoice-wrapper .line-items .total .field span {
            display: inline-block;
            margin-left: 20px;
            min-width: 85px;
            color: #84868A;
            font-size: 15px;
        }

        .receipt-content .invoice-wrapper .line-items .print {
            margin-top: 50px;
            text-align: center;
        }



        .receipt-content .invoice-wrapper .line-items .print a i {
            margin-right: 3px;
            font-size: 14px;
        }

        .receipt-content .footer {
            margin-top: 40px;
            margin-bottom: 110px;
            text-align: center;
            font-size: 12px;
            color: #969CAD;
        }
    </style>
</head>
<body>

<div class="receipt-content">
    <div class="container bootstrap snippets bootdey">
        <div class="row">
            <div class="col-md-12">
                <div class="invoice-wrapper">
                    <div class="intro text-center">
                        <strong style="font-size: 20px; font-weight: bold" class="text-primary">BC Mar - Dịch vụ Marketing</strong>,
                        <br>
                        81C Mê Linh, Lê Chân, Hải Phòng
                    </div>

                    <div class="payment-info">
                        <div class="row">
                            <div class="col-xs-6">
                                <span>Số hóa đơn</span>
                                <strong>{{$order->id}}</strong>
                            </div>
                            <div style="margin: 0px" class="col-xs-6 text-right">
                                <span>Ngày</span>
                                <strong>{{$order->updated_at}}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="payment-details">
                        <div class="row">
                            <div class="col-xs-6">
                                <span>Khách hàng</span>
                                <strong>
                                    {{$order->customer->name}}
                                </strong>
                                <p>
                                    {{$order->customer->address}} <br>
                                    {{$order->customer->phone}} <br>
                                    <a href="#">
                                        {{$order->customer->email}}
                                    </a>
                                </p>
                            </div>
                            <div style="margin: 0px" class="col-xs-6 text-right">
                                <span>Vận chuyển tới</span>
                                <strong>
                                    {{$order->shipping->name}}
                                </strong>
                                <p>
                                    {{$order->shipping->address}} <br>
                                    {{$order->shipping->phone}} <br>
                                    <a href="#">
                                        {{$order->shipping->email}}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="line-items">
                        <div class="headers clearfix">
                            <div class="row">
                                <div class="col-xs-2">Mã sản phẩm</div>
                                <div class="col-xs-3">Tên sản phẩm</div>
                                <div class="col-xs-2">Đơn giá</div>
                                <div class="col-xs-2 text-right">Số lượng</div>
                            </div>
                        </div>
                        <div class="items">
                                @php
                                    $subtotal = 0;
                                @endphp
                            @foreach($order_detail as $key => $item)
                                <div class="row item">
                                    <div class="col-xs-2 desc">
                                        {{$item->product_id}}
                                    </div>
                                    <div class="col-xs-3 qty">
                                        {{$item->product->code}}
                                    </div>
                                    <div class="col-xs-2 amount">
                                        {{number_format($item->product_price,0,',','.')}} VND
                                    </div>
                                    <div class="col-xs-2 amount text-right">
                                        {{$item->so_luong}}
                                    </div>
                                    @php
                                        $subtotal += $item->product_price * $item->so_luong;
                                    @endphp
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="border-bottom: 2px solid #EBECEE;" class="tong-tien row">
                        <div class="col-xs-6">
                            Thành tiền: <span style="font-weight: bold" class="">{{number_format($subtotal,0,',','.')}} VND</span>
                            <br>
                            Phí vận chuyển: <span style="font-weight: bold">{{number_format($order->fee_ship,0,',','.')}} VND</span>
                            <br>
                            Được giảm giá: <span style="font-weight: bold">{{number_format($order->coupon,2,',','.')}} VND</span>
                            <br>
                            VAT: <span style="font-weight: bold">0 VNĐ</span>
                            <br>
                            Tổng: <span style="font-weight: bold" class="text-primary">{{number_format($order->tong_tien,0,',','.')}} VND</span>
                        </div>
                        <div class="col-xs-5">
                            <p class="extra-notes">
                                <strong>Ghi chú đơn hàng: </strong>
                                {{$order->shipping->ghi_chu}}
                            </p>
                        </div>
                    </div>
                    <div style="margin-top: 10px" class="chu-ky row">
                        <div  class="col-xs-6">
                            <span style="font-weight: bold;color: black; margin-left: 5px">Người lập phiếu</span>
                            <br>
                            <br>
                            <p>Nguyễn Đại Dương</p>
                        </div>
                        <div class="col-xs-6">
                            <span style="font-weight: bold;color: black;margin-left: 5px">Khách hàng</span>
                            <br>
                            <br>
                            <p>{{$order->customer->name}}</p>
                        </div>
                    </div>
                </div>
{{--                <div class="footer">--}}
{{--                    Copyright © 2014. company name--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>

</body>
</html>
