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


        <div class="review-payment">
            <h2>Xem lại đơn hàng</h2>
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
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <div class="total_area">
                <ul>
                    <li>Tổng <span>{{\Gloudemans\Shoppingcart\Facades\Cart::priceTotal(0,',','.')}} đ</span></li>
                    <li>Thuế <span>{{\Gloudemans\Shoppingcart\Facades\Cart::tax(0,',','.')}} đ</span></li>
                    <li>Phí vận chuyển <span>Miễn phí</span></li>
                    <li>Thành tiền <span>{{\Gloudemans\Shoppingcart\Facades\Cart::total(0,',','.')}} đ</span></li>
                </ul>

            </div>
        </div>
        <div style="margin: 40px 0">
            <h3>Chọn hình thức thanh toán</h3>
        </div>
        <form action="{{route('customer-order')}}" method="post">
            @csrf
            <div class="payment-options">
            <span>
                <label><input name="payment_method" value="tin_dung" type="checkbox"> Thẻ tín dụng</label>
            </span>
                <span>
                <label><input name="payment_method" value="tien_mat" type="checkbox"> Tiền mặt</label>
            </span>
                <span>
                <label><input name="payment_method" value="ghi_no" type="checkbox"> Thẻ ghi nợ</label>
            </span>
                {{--            <span>--}}
                {{--						<label><input type="checkbox"> Paypal</label>--}}
                {{--					</span>--}}
                <input type="submit" value="Đặt hàng" name="order" class="btn btn-primary">
            </div>
        </form>

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
