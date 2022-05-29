@php
    $customer_id = \Illuminate\Support\Facades\Session::get('customer_id');
    $shipping_id = \Illuminate\Support\Facades\Session::get('shipping_id');
@endphp
<head>
    @include('frontend.head')
</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
</header><!--/header-->

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{route('trang-chu')}}">Home</a></li>
                <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        <div>
            <ul class="progressbar">
                <li class="active">Giỏ hàng</li>
                <li class="">Điền thông tin</li>
                <li class="">Xác nhận</li>
            </ul>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {!! session()->get('message') !!}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
        <div class="clearfix"></div>
        <div class="table-responsive cart_info">
            <form action="{{url('/update-cart-ajax')}}" method="post">
                @csrf
            <table class="table table-condensed">
                <thead>
                <tr class="cart_menu">
                    <td class="image">Hình ảnh</td>
                    <td class="description">Mô tả</td>
                    <td class="price">Giá</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Thành tiền</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @if(\Illuminate\Support\Facades\Session::get('cart')==true)

                @php
                    $total = 0;
                @endphp
                @foreach(\Illuminate\Support\Facades\Session::get('cart') as $cart)
                    @php
                        $subtotal = $cart['product_price'] * $cart['product_qty'];
                        $total += $subtotal
                    @endphp
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{url('public/uploads/products/'.$cart['product_image'])}}" width="50" alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$cart['product_name']}}</a></h4>
                                <p>ID: {{$cart['product_id']}}</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($cart['product_price'],0,'','.')}} đ</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">

                                        {{--                            <a class="cart_quantity_up" href=""> + </a>--}}
                                        <input class="cart_quantity_input" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" autocomplete="off" size="2">
                                        <input type="hidden" value="" name="rowId">

                                        {{--                            <a class="cart_quantity_down" href=""> - </a>--}}

                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    {{number_format($subtotal,0,'','.')}} đ
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{url('/delete-cart-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                            </td>

                        </tr>
                @endforeach
                <tr>
                    <td>
                        <input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-sm btn-default check_out">
                    </td>
                    <td>
                        <a href="{{url('/delete-all-cart')}}" class="btn btn-sm btn-default check_out" >Xóa toàn bộ giỏ hàng</a>
                    </td>
                    <td>
                        @if($customer_id!=null && $shipping_id==null)
                            <a class="btn btn-default check_out" href="{{route('checkout')}}"> Thanh toán</a>
                        @elseif($customer_id!=null && $shipping_id=!null)
                            <a class="btn btn-default check_out" href="{{route('payment')}}"> Thanh toán</a>
                        @else
                            <a class="btn btn-default check_out"href="{{route('login-checkout')}}"> Thanh toán</a>
                        @endif
                    </td>
                </tr>
                @else
                    <tr>
                        <td rowspan="5">
                            Giỏ hàng đang trống, mua hàng thôi!!!
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            </form>
        </div>
    </div>
</section>
<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



</body>
