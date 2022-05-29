
<!--extend nhúng file layout vào đây-->
@extends('frontend.layout')
@section('content')
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Sản phẩm mới</h2>
        @foreach($san_pham_mois as $san_pham_moi)
            @if(count($san_pham_moi->products)!=0)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                @foreach($san_pham_moi->products as $product)
                                    <a href="{{route('product',['code'=>$product->code])}}">
                                        @break
                                        @endforeach
                                        <img src="{{url('public/uploads/products/'.$san_pham_moi->anh_dai_dien)}}" alt="" />
                                        <h2>{{number_format($san_pham_moi->products[0]->gia_ban,0,'','.')}} đ</h2>
                                        <p>{{$san_pham_moi->name}}</p>
                                    </a>
                                    <button type="button" class="btn btn-default quick_view" data-toggle="modal" data-target="#quick_view"
                                            name="add-to-cart" data-product_id="{{$san_pham_moi->id}}">
                                        <i class="fa fa-eye"></i>Xem nhanh</button>
                            </div>
                            {{--                <div class="product-overlay">--}}
                            {{--                    <div class="overlay-content">--}}
                            {{--                        <h2>{{number_format($san_pham_moi->gia_ban,0,'','.')}} đ</h2>--}}
                            {{--                        <p>{{$san_pham_moi->name}}</p>--}}
                            {{--                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>--}}
                            {{--                    </div>--}}
                            {{--                </div>--}}
                        </div>
                    </div>

                </div>
            @endif
        @endforeach

    </div><!--features_items-->

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
