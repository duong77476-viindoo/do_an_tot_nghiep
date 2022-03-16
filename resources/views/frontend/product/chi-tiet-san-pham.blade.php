@extends('frontend.layout')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{route('danh-muc-san-pham',['code'=>$san_pham_chi_tiet->category_products[0]->code])}}">{{$san_pham_chi_tiet->category_products[0]->category_product_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$san_pham_chi_tiet->name}}</li>
        </ol>
    </nav>
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <ul id="imageGallery">
            @foreach($san_pham_chi_tiet->galleries as $gallery)
            <li data-thumb="{{asset('public/uploads/gallery/'.$gallery->image)}}" data-src="{{asset('public/uploads/gallery/'.$gallery->image)}}">
                <img  height="329px" width="100%" src="{{asset('public/uploads/gallery/'.$gallery->image)}}" alt="{{$gallery->name}}"/>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$san_pham_chi_tiet->name}}</h2>
            <p>ID: {{$san_pham_chi_tiet->id}}</p>
            <img src="images/product-details/rating.png" alt="" />
{{--            FORM THÊM GIỎ HÀNG BẰNG PACKAGE CART BUMBUMMEN  --}}
{{--            <form action="{{route('save-cart')}}" method="post">--}}
{{--                @csrf--}}
{{--            <span>--}}
{{--                <span>{{number_format($san_pham_chi_tiet->gia_ban,0,'','.')}} đ</span>--}}
{{--                <label>Quantity:</label>--}}
{{--                <input name="so_luong" type="text" min="1" value="1" />--}}
{{--                <input name="product_id" type="hidden" value="{{$san_pham_chi_tiet->id}}" />--}}
{{--                <button type="submit" class="btn btn-fefault cart">--}}
{{--                    <i class="fa fa-shopping-cart"></i>--}}
{{--                    Thêm vào giỏ hàng--}}
{{--                </button>--}}
{{--                <button type="button" class="btn btn-secondary add-to-cart" name="add-to-cart">--}}
{{--                    <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng ajax</button>--}}

{{--            </span>--}}
{{--            </form>--}}

{{--            FORM THÊM GIỎ HÀNG AJAX--}}
            <form action="" method="post">
                @csrf
                <span>
                    <input type="hidden"  class="cart_product_id_{{$san_pham_chi_tiet->id}}" value="{{$san_pham_chi_tiet->id}}">
                    <input type="hidden"  class="cart_product_name_{{$san_pham_chi_tiet->id}}" value="{{$san_pham_chi_tiet->name}}">
                    <input type="hidden"  class="cart_product_image_{{$san_pham_chi_tiet->id}}" value="{{$san_pham_chi_tiet->anh_dai_dien}}">
                    <input type="hidden"  class="cart_product_price_{{$san_pham_chi_tiet->id}}" value="{{$san_pham_chi_tiet->gia_ban}}">
                    <input type="hidden"  class="product_qty_{{$san_pham_chi_tiet->id}}" value="{{$san_pham_chi_tiet->so_luong}}">

                    <span>{{number_format($san_pham_chi_tiet->gia_ban,0,'','.')}} đ</span>
                    <label>Quantity:</label>
                    <input name="so_luong" class="cart_product_qty_{{$san_pham_chi_tiet->id}}" type="number" min="1" value="1" />
                    <input name="product_id" type="hidden" value="{{$san_pham_chi_tiet->id}}" />
                    <button type="button" class="btn btn-fefault add-to-cart" name="add-to-cart" data-product_id="{{$san_pham_chi_tiet->id}}">
                        <i class="fa fa-shopping-cart"></i>
                        Thêm vào giỏ hàng
                    </button>

                </span>
            </form>
            <p><b>Tình trạng:</b>
                @if($san_pham_chi_tiet->tinh_trang==1)
                    {{ 'Còn hàng' }}
                @else
                    {{'Hết hàng' }}
                @endif
            </p>
            <p><b>Điều kiện:</b> Mới</p>
            <p><b>Thương hiệu:</b> {{$san_pham_chi_tiet->brand->brand_name}}</p>
            <p><b>Danh mục:</b>
                @foreach($san_pham_chi_tiet->category_products as $category_product)
                    {{$category_product->category_product_name}}
                @endforeach</p>
            <style type="text/css">
                a.tags_style{
                    margin: 3px 2px;
                    border: 1px solid;

                    height: auto;
                    background: #428bca;
                    color: #ffff;
                    padding: 0px;
                }
                a.tags_style:hover{
                    background: black;
                }
            </style>
            <fieldset>
                <legend>Tags</legend>
                <p>
                    <i class="fa fa-bag"></i>
                    @foreach($san_pham_chi_tiet->tags as $tag_san_pham)
                        <a href="{{route('tag',['code'=>$tag_san_pham->code])}}" class="tags_style">{{$tag_san_pham->name}}</a>
                    @endforeach
                </p>
            </fieldset>
            <div class="fb-like"
                 data-href="{{$url_canonical}}"
                 data-width="" data-layout="button_count"
                 data-action="like" data-size="small" data-share="true"></div>
{{--            <a href=""><img src="{{url('public/frontend/images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>--}}
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#video_review" data-toggle="tab">Video review</a></li>
            <li><a href="#details" data-toggle="tab">Mô tả sản phẩm</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Thông số kỹ thuật</a></li>

            <li><a href="#reviews" data-toggle="tab">Đánh giá (5)</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="active in tab-pane fade text-center" id="video_review">
            <form>
                @csrf
            <img src="{{asset('public/uploads/videos/'.$san_pham_chi_tiet->video->image)}}" width="100%" height="300px">
            <!-- Button trigger modal -->
            <button type="button" id="{{$san_pham_chi_tiet->video_id}}" class="btn btn-primary watch-video" data-toggle="modal" data-target="#video_modal">
                Click để xem
            </button>
            </form>
        </div>
        <div class="tab-pane fade" id="details">
            <h3>{{$san_pham_chi_tiet->mo_ta_ngan_gon}}</h3>
            <p>{!! $san_pham_chi_tiet->mo_ta_chi_tiet!!}</p>
        </div>

        <div class="tab-pane fade" id="companyprofile" >
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="images/home/gallery1.jpg" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="images/home/gallery3.jpg" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="images/home/gallery2.jpg" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="images/home/gallery4.jpg" alt="" />
                            <h2>$56</h2>
                            <p>Easy Polo Black Edition</p>
                            <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade " id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <p><b>Write Your Review</b></p>

                <form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
                    <textarea name="" ></textarea>
                    <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                    <button type="button" class="btn btn-default pull-right">
                        Submit
                    </button>
                </form>
            </div>
        </div>

    </div>
</div><!--/category-tab-->
<div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="5"></div>
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm liên quan</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @php
                $i=0;
            @endphp
            @foreach($san_phams_lien_quan as $key=>$san_pham)
                @php
                    $i++;
                @endphp
                <div class="item {{$i==1 ? 'active' : ''}}">
                    <a href="{{route('product',['code'=>$san_pham->code])}}">
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{url('public/uploads/products/'.$san_pham->anh_dai_dien)}}" alt="" />
                                        <h2>{{number_format($san_pham->gia_ban,0,'','.')}} đ</h2>
                                        <p>{{$san_pham->name}}</p>
                                        <button type="button" class="btn btn-default "><i class="fa fa-shopping-cart"></i>Xem chi tiết</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
            @endforeach


        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
    <!-- Modal xem video-->
    <div class="modal fade" id="video_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="video_title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="video_desc">

                    </div>
                    <div id="video_link">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div><!--/recommended_items-->
@endsection


