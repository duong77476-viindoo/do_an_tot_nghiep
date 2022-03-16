@php
    $customer_id = \Illuminate\Support\Facades\Session::get('customer_id');
    $shipping_id = \Illuminate\Support\Facades\Session::get('shipping_id');
    $fee_ship = \Illuminate\Support\Facades\Session::get('fee')
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
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="register-req">
            <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sủ mua hàng</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
{{--                <div class="col-sm-3">--}}
{{--                    <div class="shopper-info">--}}
{{--                        <p>Shopper Information</p>--}}
{{--                        <form>--}}
{{--                            <input type="text" placeholder="Display Name">--}}
{{--                            <input type="text" placeholder="User Name">--}}
{{--                            <input type="password" placeholder="Password">--}}
{{--                            <input type="password" placeholder="Confirm password">--}}
{{--                        </form>--}}
{{--                        <a class="btn btn-primary" href="">Get Quotes</a>--}}
{{--                        <a class="btn btn-primary" href="">Continue</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-6 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin đơn hàng</p>
                        <div class="form-one">
                            <form action="{{route('save-checkout')}}" method="post">
                                @csrf
                                <input  type="text" placeholder="Company Name">
                                <input  type="text" class="email" name="email" placeholder="Email*">
                                <input  type="text" class="name" name="name" placeholder="Họ tên">
                                <input  type="text" class="phone" name="phone" placeholder="Điện thoại">
                                <textarea class="address" style="margin: 5px 0"  name="address"  placeholder="Địa chỉ" rows="3"></textarea>
                                <textarea class="note" name="ghi_chu"  placeholder="Ghi chú đơn hàng" rows="5"></textarea>

                                @if(\Illuminate\Support\Facades\Session::get('fee'))
                                    <input type="hidden" name="fee_ship" class="fee_ship" value="{{$fee_ship}}">
                                @else
                                    <input type="hidden" name="fee_ship" class="fee_ship" value="20000">
                                @endif

                                @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                    @foreach(\Illuminate\Support\Facades\Session::get('coupon') as $key=>$cou)
                                    <input type="hidden" name="coupon" class="coupon" value="{{$cou['code']}}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="coupon" class="coupon" value="no">
                                @endif

                                <div class="">
                                    <div class="form-group">
                                        <label>Chọn hình thức thanh toán</label>
                                        <select name="payment_type" id="city" class="form-control choose payment_type">
                                            <option value="atm">Thẻ ATM nội địa</option>
                                            <option value="tien_mat">Tiền mặt</option>
                                        </select>
                                    </div>
                                </div>

                                <input type="button" value="Xác nhận đơn hàng" name="order" class="btn btn-primary confirm-order">

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bill-to">
                        <p>Điền thông tin vận chuyển</p>
                        <div class="form-two">
                            <form id="form-fee-ship" action="" method="post">
                                {{csrf_field()}}

                                <div class="form-group">
                                    <label>Chọn tỉnh thành phố</label>
                                    <select name="city" id="city" class="form-control choose city">

                                        <option value="">---Chọn---</option>
                                        @foreach($cities as $key=>$city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Chọn quận huyện</label>
                                    <select name="province" id="province" class="form-control choose province">
                                        <option value="">---Chọn---</option>
                                    </select>
                                </div> <div class="form-group">
                                    <label>Chọn xã phường</label>
                                    <select name="ward" id="ward" class="form-control ward">
                                        <option value="">---Chọn---</option>
                                    </select>
                                </div>
                                <input type="button" value="Tính phí vận chuyển" name="calculate_fee_ship" class="btn btn-primary calculate_fee_ship">
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="review-payment">
            <h2>Xem lại đơn hàng</h2>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {{session()->get('error')}}
            </div>
        @endif
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
                                        <input disabled class="cart_quantity_input" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" autocomplete="off" size="2">
                                        <input type="hidden" value="" name="rowId">

                                        {{--                            <a class="cart_quantity_down" href=""> - </a>--}}

                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">
                                        {{number_format($subtotal,0,'','.')}} đ
                                    </p>
                                </td>
{{--                                <td class="cart_delete">--}}
{{--                                    <a class="cart_quantity_delete" href="{{url('/delete-cart-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                <input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-sm btn-default check_out">--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <a href="{{url('/delete-all-cart')}}" class="btn btn-sm btn-default check_out" >Xóa toàn bộ giỏ hàng</a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
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
</section> <!--/#cart_items-->
@if(\Illuminate\Support\Facades\Session::get('cart')==true)
    <section id="do_action">
        <div class="container">
            <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="chose_area">
                        <ul class="user_option">
                            <li>
                                <input type="checkbox">
                                <label>Use Coupon Code</label>
                            </li>
                            <li>
                                <input type="checkbox">
                                <label>Use Gift Voucher</label>
                            </li>
                            <li>
                                <input type="checkbox">
                                <label>Estimate Shipping & Taxes</label>
                            </li>
                        </ul>
                        <ul class="user_info">
                            <li class="single_field">
                                <label>Country:</label>
                                <select>
                                    <option>United States</option>
                                    <option>Bangladesh</option>
                                    <option>UK</option>
                                    <option>India</option>
                                    <option>Pakistan</option>
                                    <option>Ucrane</option>
                                    <option>Canada</option>
                                    <option>Dubai</option>
                                </select>

                            </li>
                            <li class="single_field">
                                <label>Region / State:</label>
                                <select>
                                    <option>Select</option>
                                    <option>Dhaka</option>
                                    <option>London</option>
                                    <option>Dillih</option>
                                    <option>Lahore</option>
                                    <option>Alaska</option>
                                    <option>Canada</option>
                                    <option>Dubai</option>
                                </select>

                            </li>
                            <li class="single_field zip-field">
                                <label>Zip Code:</label>
                                <input type="text">
                            </li>
                        </ul>
                        <a class="btn btn-default update" href="">Get Quotes</a>
                        <a class="btn btn-default check_out" href="">Continue</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="total_area">
                        @php
                            $total_coupon = 0;
                        @endphp
                        <ul>
                            <li>Tổng tiền<span> {{number_format($total,0,'','.')}} đ</span></li>
                            @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                <li>
                                    <a class="cart_quantity_delete" href="{{url('/delete-coupon')}}"><i class="fa fa-times"></i></a>
                                    @foreach(\Illuminate\Support\Facades\Session::get('coupon') as $key=>$coupon)
                                        @if($coupon['tinh_nang']==1)
                                            Mã giảm giá: {{$coupon['code']}}
                                            <br>
                                            Phần trăm giảm : {{$coupon['tien_giam']}} %
                                            <br>
                                            <p>
                                                @php
                                                    $total_coupon = ($total*$coupon['tien_giam'])/100;
                                                    echo "<p>Được giảm giá: " .number_format($total_coupon,0,'','.').' đ</p>'
                                                @endphp
                                            </p>
                                        @else
                                            Mã giảm giá: {{$coupon['code']}}
                                            <br>
                                            Số tiền giảm : {{number_format($coupon['tien_giam'],0,'','.')}} đ
                                            <br>
                                            <p>
                                                @php
                                                    $total_coupon = $coupon['tien_giam'];
                                                    echo "<p>Được giảm giá: " .number_format($total_coupon,0,'','.').' đ</p>'
                                                @endphp
                                            </p>
                                        @endif
                                    @endforeach
                                </li>
                            @endif
                            <li>Thuế <span></span></li>
                            @if(\Illuminate\Support\Facades\Session::get('fee'))
                                <li>
                                    <a class="cart_quantity_delete" href="{{url('/delete-fee')}}"><i class="fa fa-times"></i></a>
                                    Phí vận chuyển <span>{{number_format(\Illuminate\Support\Facades\Session::get('fee'),0,'','.')}} đ</span></li>
                            @endif
                                @if($total-$total_coupon<0)
                                <li>Tiền thanh toán sau giảm giá <span>{{0}} đ</span></li>
                            @else
                                <li>Tiền thanh toán sau giảm giá <span>{{number_format($total-$total_coupon+$fee_ship,0,'','.')}} đ</span></li>

                            @endif
                        </ul>
                        {{--                    <a class="btn btn-default update" href="">Update</a>--}}

                        @if(\Illuminate\Support\Facades\Session::get('cart'))
                            <form method="post" action="{{url('/check-coupon')}}">
                                @csrf
                                <input type="text" name="coupon" class="form-control" placeholder="Nhập mã giảm giá"><br>
                                <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá">

                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->
@endif

<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



<script src="{{url('public/frontend/js/jquery.js')}}js/jquery.js"></script>
<script src="{{url('public/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{url('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{url('public/frontend/js/main.js')}}"></script>
</body>
