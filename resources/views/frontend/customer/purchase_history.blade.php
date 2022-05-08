<head>
    @include('frontend.head')
</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
</header><!--/header-->

<div class="container">
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Lịch sử mua hàng</h2>
        </div>
        <?php
        $message = \Illuminate\Support\Facades\Session::get('message');
        if($message){
            echo $message;
            \Illuminate\Support\Facades\Session::put('message',null);
        }
        ?>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped b-t b-light">
                <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Mã vận chuyển</th>
                    <th>Mã hóa đơn thanh toán</th>
                    <th>Hình thức thanh toán</th>
                    <th>Phí vận chuyển</th>
                    <th>Coupon</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>

                </tr>
                </thead>
                <tbody>
                @foreach($orders as $key => $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->customer->name}}</td>
                        <td>{{$order->shipping->id}}</td>
                        <td>{{$order->payment->id}}</td>
                        <td>{{$order->payment->method}}</td>
                        <td>{{number_format($order->fee_ship,0,'','.')}} đ</td>
                        <td>{{number_format($order->coupon,2,',','.')}} đ</td>
                        <td>{{number_format($order->tong_tien,2,',','.')}} đ</td>
                        <td>{{$order->trang_thai}}</td>
                        <td>{{$order->created_at}}</td>
                        <td><span class="text-ellipsis">{{$order->updated_at}}</span></td>
                        <td>
                            <a href="{{route('detail-purchase-history',['id'=>$order->id])}}" class="active" ui-toggle-class="">
                                <i class="fa fa-eye text-success text-active"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



</body>
