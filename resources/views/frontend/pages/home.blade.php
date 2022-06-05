
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
            </div>
        </div>

    </div>
        @endif
    @endforeach

</div><!--features_items-->

@if(!is_null($brands))
<div class="category-tab"><!--phụ-kiện-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            @foreach($brands as $key=>$brand)
                <li class="tab-{{$brand->brand_slug}} {{$key==0 ? 'active' : ''}}"><a href="#{{$brand->brand_slug}}" data-toggle="tab">{{$brand->brand_name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="tab-content">
        @foreach($brands as $key=>$brand)
                <div class="tab-pane fade {{$key==0 ? 'active in' : ''}} tab-product {{$brand->brand_slug}}" id="{{$brand->brand_slug}}">
                    @foreach($brand->product_groups as $san_pham_moi)
                        <div class="col-sm-3">
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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
    </div>
</div><!--/category-tab-->
@endif

<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm nổi bật</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <ul id="carousel_product">
                @foreach($san_phams_carousel as $key=>$san_pham)
                    <li>
                        @foreach($san_pham->products as $product)
                            <a href="{{route('product',['code'=>$product->code])}}">
                                @break
                                @endforeach
                                <div class="col-sm-8">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="{{url('public/uploads/products/'.$san_pham->anh_dai_dien)}}" alt="" />
                                                <h2>{{number_format($san_pham->products[0]->gia_ban,0,'','.')}} đ</h2>
                                                <p>{{$san_pham->name}}</p>
                                                <button type="button" class="btn btn-default "><i class="fa fa-shopping-cart"></i>Xem chi tiết</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</div><!--/recommended_items-->

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

@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#carousel_product').lightSlider({
                autoWidth:true,
                loop:true,
                speed: 400, //ms'
                auto: true,
                enableDrag:false,
                pager:false,
                item:3,
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function (){
            @if(!is_null($brands))
            @foreach($brands as $brand)

            $('.tab-{{$brand->brand_slug}}').click(function (){
                $('.tab-product').removeClass('active in');
                $('.{{$brand->brand_slug}}').addClass('active in');
            });
            @endforeach
            @endif
        })
    </script>
@endsection
