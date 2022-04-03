@extends('frontend.layout')
@section('content')
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Kết quả cho <span class="text text-success">{{$tu_khoa}}</span></h2>
        @foreach($san_pham_tim_kiem as $san_pham)
            <a href="{{route('product',['code'=>$san_pham->code])}}">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <form>
                                    {{--                        @csrf--}}
                                    {{--                        <input type="hidden"  class="cart_product_id_{{$san_pham_moi->id}}" value="{{$san_pham_moi->id}}">--}}
                                    {{--                        <input type="hidden"  class="cart_product_name_{{$san_pham_moi->id}}" value="{{$san_pham_moi->name}}">--}}
                                    {{--                        <input type="hidden"  class="cart_product_image_{{$san_pham_moi->id}}" value="{{$san_pham_moi->anh_dai_dien}}">--}}
                                    {{--                        <input type="hidden"  class="cart_product_price_{{$san_pham_moi->id}}" value="{{$san_pham_moi->gia_ban}}">--}}
                                    {{--                        <input type="hidden"  class="cart_product_qty_{{$san_pham_moi->id}}" value="1" >--}}
                                    {{--                        <input type="hidden"  class="product_qty_{{$san_pham_moi->id}}" value="{{$san_pham_moi->so_luong}}">--}}
                                    @foreach($san_pham->products as $product)
                                        <a href="{{route('product',['code'=>$product->code])}}">
                                            @break
                                            @endforeach
                                            <img src="{{url('public/uploads/products/'.$san_pham->anh_dai_dien)}}" alt="" />
                                            <h2>{{number_format($san_pham->gia_ban,0,'','.')}} đ</h2>
                                            <p>{{$san_pham->name}}</p>
                                            {{--                    <a href="{{route('product',['code'=>$san_pham_moi->code])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>--}}

                                        </a>
                                        {{--                        <button type="button" class="btn btn-default add-to-cart" name="add-to-cart" data-product_id="{{$san_pham_moi->id}}">--}}
                                        {{--                            <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>--}}
                                        <button type="button" class="btn btn-default quick_view" data-toggle="modal" data-target="#quick_view"
                                                name="add-to-cart" data-product_id="{{$san_pham->id}}">
                                            <i class="fa fa-eye"></i>Xem nhanh</button>
                                {{--                    </form>--}}
                            </div>
                            {{--                <div class="product-overlay">--}}
                            {{--                    <div class="overlay-content">--}}
                            {{--                        <h2>{{number_format($san_pham_moi->gia_ban,0,'','.')}} đ</h2>--}}
                            {{--                        <p>{{$san_pham_moi->name}}</p>--}}
                            {{--                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>--}}
                            {{--                    </div>--}}
                            {{--                </div>--}}
                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào danh sách yêu thích</a></li>
                                <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào danh sách so sánh</a></li>
                            </ul>
                        </div>
                    </div>

                </div>

            </a>
        @endforeach

    </div><!--features_items-->
@endsection
