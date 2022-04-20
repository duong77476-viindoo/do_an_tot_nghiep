<?php
?>
<!--extend nhúng file layout vào đây-->
@extends('frontend.layout')
@section('content')
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Tags {{$tag->name}}</h2>
        @foreach($sanphams_by_tag as $san_pham)
            <a href="{{route('product',['code'=>$san_pham->code])}}">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <form>
                                    @csrf
                                    <input type="hidden"  class="cart_product_id_{{$san_pham->id}}" value="{{$san_pham->id}}">
                                    <input type="hidden"  class="cart_product_name_{{$san_pham->id}}" value="{{$san_pham->name}}">
                                    <input type="hidden"  class="cart_product_image_{{$san_pham->id}}" value="{{$san_pham->anh_dai_dien}}">
                                    <input type="hidden"  class="cart_product_price_{{$san_pham->id}}" value="{{$san_pham->gia_ban}}">
                                    <input type="hidden"  class="cart_product_qty_{{$san_pham->id}}" value="1" >
                                    <input type="hidden"  class="product_qty_{{$san_pham->id}}" value="{{$san_pham->so_luong}}">

                                    <a href="{{route('product',['code'=>$san_pham->code])}}">
                                        <img src="{{url('public/uploads/products/'.$san_pham->anh_dai_dien)}}" alt="" />
                                        <h2>{{number_format($san_pham->gia_ban,0,'','.')}} đ</h2>
                                        <p>{{$san_pham->name}}</p>
                                        {{--                    <a href="{{route('product',['code'=>$san_pham->code])}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>--}}

                                    </a>
                                    <button type="button" class="btn btn-default add-to-cart" name="add-to-cart" data-product_id="{{$san_pham->id}}">
                                        <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                                    <button type="button" class="btn btn-default quick_view" data-toggle="modal" data-target="#quick_view"
                                            name="add-to-cart" data-product_id="{{$san_pham->id}}">
                                        <i class="fa fa-eye"></i>Xem nhanh</button>
                                </form>
                            </div>
                            {{--                <div class="product-overlay">--}}
                            {{--                    <div class="overlay-content">--}}
                            {{--                        <h2>{{number_format($san_pham->gia_ban,0,'','.')}} đ</h2>--}}
                            {{--                        <p>{{$san_pham->name}}</p>--}}
                            {{--                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>--}}
                            {{--                    </div>--}}
                            {{--                </div>--}}
                        </div>
{{--                        <div class="choose">--}}
{{--                            <ul class="nav nav-pills nav-justified">--}}
{{--                                <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào danh sách yêu thích</a></li>--}}
{{--                                <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào danh sách so sánh</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </div>

                </div>
            </a>
        @endforeach

    </div><!--features_items-->

    {{--    <div class="category-tab"><!--category-tab-->--}}
    {{--        <div class="col-sm-12">--}}
    {{--            <ul class="nav nav-tabs">--}}
    {{--                <li class="active"><a href="#tshirt" data-toggle="tab">T-Shirt</a></li>--}}
    {{--                <li><a href="#blazers" data-toggle="tab">Blazers</a></li>--}}
    {{--                <li><a href="#sunglass" data-toggle="tab">Sunglass</a></li>--}}
    {{--                <li><a href="#kids" data-toggle="tab">Kids</a></li>--}}
    {{--                <li><a href="#poloshirt" data-toggle="tab">Polo shirt</a></li>--}}
    {{--            </ul>--}}
    {{--        </div>--}}
    {{--        <div class="tab-content">--}}
    {{--            <div class="tab-pane fade active in" id="tshirt" >--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery1.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery2.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery3.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery4.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--            <div class="tab-pane fade" id="blazers" >--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery4.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery3.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery2.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery1.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--            <div class="tab-pane fade" id="sunglass" >--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery3.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery4.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery1.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery2.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--            <div class="tab-pane fade" id="kids" >--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery1.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery2.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery3.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery4.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--            <div class="tab-pane fade" id="poloshirt" >--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery2.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery4.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery3.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <div class="product-image-wrapper">--}}
    {{--                        <div class="single-products">--}}
    {{--                            <div class="productinfo text-center">--}}
    {{--                                <img src="images/home/gallery1.jpg" alt="" />--}}
    {{--                                <h2>$56</h2>--}}
    {{--                                <p>Easy Polo Black Edition</p>--}}
    {{--                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div><!--/category-tab-->--}}

    {{--    <div class="recommended_items"><!--recommended_items-->--}}
    {{--        <h2 class="title text-center">recommended items</h2>--}}

    {{--        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">--}}
    {{--            <div class="carousel-inner">--}}
    {{--                <div class="item active">--}}
    {{--                    <div class="col-sm-4">--}}
    {{--                        <div class="product-image-wrapper">--}}
    {{--                            <div class="single-products">--}}
    {{--                                <div class="productinfo text-center">--}}
    {{--                                    <img src="images/home/recommend1.jpg" alt="" />--}}
    {{--                                    <h2>$56</h2>--}}
    {{--                                    <p>Easy Polo Black Edition</p>--}}
    {{--                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                                </div>--}}

    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-sm-4">--}}
    {{--                        <div class="product-image-wrapper">--}}
    {{--                            <div class="single-products">--}}
    {{--                                <div class="productinfo text-center">--}}
    {{--                                    <img src="images/home/recommend2.jpg" alt="" />--}}
    {{--                                    <h2>$56</h2>--}}
    {{--                                    <p>Easy Polo Black Edition</p>--}}
    {{--                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                                </div>--}}

    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-sm-4">--}}
    {{--                        <div class="product-image-wrapper">--}}
    {{--                            <div class="single-products">--}}
    {{--                                <div class="productinfo text-center">--}}
    {{--                                    <img src="images/home/recommend3.jpg" alt="" />--}}
    {{--                                    <h2>$56</h2>--}}
    {{--                                    <p>Easy Polo Black Edition</p>--}}
    {{--                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                                </div>--}}

    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="item">--}}
    {{--                    <div class="col-sm-4">--}}
    {{--                        <div class="product-image-wrapper">--}}
    {{--                            <div class="single-products">--}}
    {{--                                <div class="productinfo text-center">--}}
    {{--                                    <img src="images/home/recommend1.jpg" alt="" />--}}
    {{--                                    <h2>$56</h2>--}}
    {{--                                    <p>Easy Polo Black Edition</p>--}}
    {{--                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                                </div>--}}

    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-sm-4">--}}
    {{--                        <div class="product-image-wrapper">--}}
    {{--                            <div class="single-products">--}}
    {{--                                <div class="productinfo text-center">--}}
    {{--                                    <img src="images/home/recommend2.jpg" alt="" />--}}
    {{--                                    <h2>$56</h2>--}}
    {{--                                    <p>Easy Polo Black Edition</p>--}}
    {{--                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                                </div>--}}

    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-sm-4">--}}
    {{--                        <div class="product-image-wrapper">--}}
    {{--                            <div class="single-products">--}}
    {{--                                <div class="productinfo text-center">--}}
    {{--                                    <img src="images/home/recommend3.jpg" alt="" />--}}
    {{--                                    <h2>$56</h2>--}}
    {{--                                    <p>Easy Polo Black Edition</p>--}}
    {{--                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
    {{--                                </div>--}}

    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">--}}
    {{--                <i class="fa fa-angle-left"></i>--}}
    {{--            </a>--}}
    {{--            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">--}}
    {{--                <i class="fa fa-angle-right"></i>--}}
    {{--            </a>--}}
    {{--        </div>--}}
    {{--    </div><!--/recommended_items-->--}}
    <div class="modal fade" id="quick_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title product_quickview_title" id="exampleModalLabel">
                        <span id="product_quickview_title"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <span id="product_quickview_image"></span>
                            <span id="product_quickview_gallery"></span>
                        </div>
                        <div class="col-md-7">
                            <style type="text/css">
                                h5.modal-title.product_quickview_title{
                                    text-align: center;
                                    font-size: 25px;
                                    color: brown;
                                }
                                p.quickview{
                                    font-size: 14px;
                                    color: brown;
                                }
                                span#product_quickview_content{
                                    width: 100%;
                                }
                                span#product_quickview_content img{
                                    width: 100%;
                                }
                                @media screen and (min-width: 768px) {
                                    .modal-dialog{
                                        width: 700px;
                                    }
                                    .modal-sm{
                                        width: 350px;
                                    }
                                }
                                @media screen and (min-width: 992px){
                                    .modal-lg{
                                        width: 1200px;
                                    }
                                }
                            </style>
                            <form>
                                @csrf
                                <div id="product_quickview_value"></div>
                                <h2 class="quickview">
                                    <span id="product_quickview_title"></span>
                                </h2>
                                <p>Mã ID: <span id="product_quickview_id"></span></p>

                                <span>
                            <h2 style="color: #FE980F">Giá sản phẩm: <span id="product_quickview_price"></span>
                            </h2><br>
                            <label>Số lượng: </label>
                            <div id="product_quickview_cartQty"></div>
{{--                            <input name="product_quickview_id" type="hidden" value="">--}}
                        </span>
                                <br>
                                <div>
                                    <div style="display: inline-block" id="product_quickview_button"></div>
                                    <div style="display: inline-block" id="go_to_product_detail"></div>
                                </div>
                                <div id="beforesend_quickview"></div>
                                <br>
                                <h3 class="quickview">Mô tả sản phẩm</h3>
                                <fieldset>
                                    <span style="width: 100%" id="product_quickview_desc"></span>
                                    <span style="width: 100%" id="product_quickview_content"></span>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
