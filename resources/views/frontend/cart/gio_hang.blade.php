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
        <div class="table-responsive cart_info">
            <?php
            $content = \Gloudemans\Shoppingcart\Facades\Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                <tr class="cart_menu">
                    <td class="image">Hình ảnh</td>
                    <td class="description">Mô tả</td>
                    <td class="price">Giá</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Tổng</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @if(\Gloudemans\Shoppingcart\Facades\Cart::count()==0)
                    <tr>
                        <td rowspan="5">
                            Giỏ hàng đang trống, mua hàng thôi!!!
                        </td>
                    </tr>
                @else
                    @foreach($content as $item)
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{url('public/uploads/products/'.$item->options->image)}}" width="50" alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$item->name}}</a></h4>
                                <p>ID: {{$item->id}}</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($item->price,0,'','.')}} đ</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <form action="{{route('update-cart-quantity')}}" method="post">
                                        @csrf
                                        {{--                            <a class="cart_quantity_up" href=""> + </a>--}}
                                        <input class="cart_quantity_input" type="number" name="quantity" value="{{$item->qty}}" autocomplete="off" size="2">
                                        <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-sm btn-default">
                                        <input type="hidden" value="{{$item->rowId}}" name="rowId">

                                        {{--                            <a class="cart_quantity_down" href=""> - </a>--}}
                                    </form>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    @php
                                        $item_subtotal = $item->price * $item->qty;
                                        echo number_format($item_subtotal,0,'','.').' đ';
                                    @endphp
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{route('delete-cart-item',['id'=>$item->rowId])}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>


                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->
@if(\Gloudemans\Shoppingcart\Facades\Cart::count()!=0)
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
                    <ul>
                        <li>Tổng <span>{{\Gloudemans\Shoppingcart\Facades\Cart::priceTotal(0,',','.')}} đ</span></li>
                        <li>Thuế <span>{{\Gloudemans\Shoppingcart\Facades\Cart::tax(0,',','.')}} đ</span></li>
                        <li>Phí vận chuyển <span>Miễn phí</span></li>
                        <li>Thành tiền <span>{{\Gloudemans\Shoppingcart\Facades\Cart::total(0,',','.')}} đ</span></li>
                    </ul>
{{--                    <a class="btn btn-default update" href="">Update</a>--}}

                    @if($customer_id!=null && $shipping_id==null)
                        <a class="btn btn-default check_out" href="{{route('checkout')}}"> Thanh toán</a>
                    @elseif($customer_id!=null && $shipping_id=!null)
                        <a class="btn btn-default check_out" href="{{route('payment')}}"> Thanh toán</a>
                    @else
                        <a class="btn btn-default check_out"href="{{route('login-checkout')}}"> Thanh toán</a>
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
