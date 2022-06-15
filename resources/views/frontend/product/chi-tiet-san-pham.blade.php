@extends('frontend.layout')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{route('danh-muc-san-pham',['code'=>$nhom_san_pham->category_products[0]->code])}}">{{$nhom_san_pham->category_products[0]->category_product_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$nhom_san_pham->name}}</li>
        </ol>
    </nav>
    <div class="choose">
        <ul class="nav nav-pills nav-justified">
            <li><i class="fa fa-plus-square"></i>
                <input type="hidden" id="wishlist_productname{{$phien_ban_san_pham->id}}"
                       value="{{$phien_ban_san_pham->name}}">
                <input type="hidden" id="wishlist_productprice{{$phien_ban_san_pham->id}}"
                       value="{{number_format($phien_ban_san_pham->gia_ban,0,'','.')}} đ">
                <input type="hidden" id="wishlist_producturl{{$phien_ban_san_pham->id}}"
                       value="{{route('product',['code'=>$phien_ban_san_pham->code])}}">
                <input type="hidden" id="wishlist_productimage{{$phien_ban_san_pham->id}}"
                       value="{{url('public/uploads/products/'.$nhom_san_pham->anh_dai_dien)}}">
                <button class="button_wishlist btn btn-primary" id="{{$phien_ban_san_pham->id}}"
                        onclick="add_wishlist(this.id)"><span>Yêu thích</span></button>
            </li>
            <li><i class="fa fa-plus-square"></i>
                <button class="button_wishlist btn btn-primary"><span>So sánh</span></button>
            </li>
        </ul>
    </div>
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <ul id="imageGallery">
            @foreach($nhom_san_pham->galleries as $gallery)
            <li data-thumb="{{asset('public/uploads/gallery/'.$gallery->image)}}" data-src="{{asset('public/uploads/gallery/'.$gallery->image)}}">
                <img  height="329px" width="100%" src="{{asset('public/uploads/gallery/'.$gallery->image)}}" alt="{{$gallery->name}}"/>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-7">
        <style>
            .box-version{
                border: 1px solid #CCCCCC
            }
            .box-active{
                background: #b1c1bf;
                border: 1px solid #0a92dd;
            }
        </style>
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$nhom_san_pham->name}}</h2>
{{--            <p>ID: {{$nhom_san_pham->id}}</p>--}}
            <div class="row">
                @foreach($nhom_san_pham->products as $product)
                    <div class="col-md-4 btn btn-default text-white box-version {{$product->code==$phien_ban_san_pham->code ? 'box-active':''}}">
                        <a href="{{route('product',['code'=>$product->code])}}">{{$product->sku}}</a>
                    </div>
                @endforeach
            </div>
            <img src="images/product-details/rating.png" alt="" />
{{--            FORM THÊM GIỎ HÀNG BẰNG PACKAGE CART BUMBUMMEN  --}}
{{--            <form action="{{route('save-cart')}}" method="post">--}}
{{--                @csrf--}}
{{--            <span>--}}
{{--                <span>{{number_format($nhom_san_pham->gia_ban,0,'','.')}} đ</span>--}}
{{--                <label>Quantity:</label>--}}
{{--                <input name="so_luong" type="text" min="1" value="1" />--}}
{{--                <input name="product_id" type="hidden" value="{{$nhom_san_pham->id}}" />--}}
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
                    <input type="hidden"  class="cart_product_id_{{$phien_ban_san_pham->id}}" value="{{$phien_ban_san_pham->id}}">
                    <input type="hidden"  class="cart_product_name_{{$phien_ban_san_pham->id}}" value="{{$phien_ban_san_pham->name}}">
                    <input type="hidden"  class="cart_product_image_{{$phien_ban_san_pham->id}}" value="{{$nhom_san_pham->anh_dai_dien}}">
                    <input type="hidden"  class="cart_product_price_{{$phien_ban_san_pham->id}}" value="{{$phien_ban_san_pham->gia_ban}}">
                    <input type="hidden"  class="product_qty_{{$phien_ban_san_pham->id}}" value="{{$phien_ban_san_pham->so_luong}}">

                    <span>{{number_format($phien_ban_san_pham->gia_ban,0,'','.')}} đ</span>

                    @if($phien_ban_san_pham->so_luong==0)
                        <p class="text-primary">Sản phảm hiện hết hàng, bạn vẫn có thể liên hệ bộ phận hỗ trợ khách hàng ở góc phải màn hình để đặt hàng nhé!</p>
                    @else
                        <label>Số lượng:</label>
                        <input name="so_luong" class="cart_product_qty_{{$phien_ban_san_pham->id}}" type="number" min="1" max="{{$phien_ban_san_pham->so_luong}}" value="1" />
                        <input name="product_id" class="product_id" type="hidden" value="{{$phien_ban_san_pham->id}}" />
                        <button type="button" class="btn btn-fefault add-to-cart" name="add-to-cart" data-product_id="{{$phien_ban_san_pham->id}}">
                        <i class="fa fa-shopping-cart"></i>
                        Thêm vào giỏ hàng
                    </button>
                    @endif

                </span>
            </form>
            <p><b>Tình trạng:</b>
                @if($phien_ban_san_pham->so_luong!=0)
                    {{ 'Còn hàng' }}
                @else
                    {{'Hết hàng' }}
                @endif
            </p>
            <p><b>Điều kiện:</b> Mới</p>
            <p><b>Thương hiệu:</b> {{$nhom_san_pham->brand->brand_name}}</p>
            <p><b>Danh mục:</b>
                @foreach($nhom_san_pham->category_products as $category_product)
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
                    @foreach($nhom_san_pham->tags as $tag_san_pham)
                        <a href="{{route('tag',['code'=>$tag_san_pham->code])}}" class="tags_style">{{$tag_san_pham->name}}</a>
                    @endforeach
                </p>
            </fieldset>
            <ul class="list-inline" title="Average Rating">
                @for($count=1;$count<=5;$count++)
                    @php
                        if ($count<=$rating)
                            $color = 'color:#ffcc00;';//nếu count<rating thì hiện màu vàng để hiển thị sao
                        else
                            $color = 'color:#ccc;';//Ngược lại sao màu xám
                    @endphp
                    <li title="Đánh giá sao"
                        id=""
                        data-index="{{$count}}"
                        data-product_id="{{$phien_ban_san_pham->id}}"
                        data-rating="{{$rating}}"
                        class=""
                        style="cursor: pointer; {{$color}} font-size: 30px">
                        &#9733;
                    </li>
                @endfor
            </ul>
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
            <li><a href="#comments" data-toggle="tab">Bình luận ({{$phien_ban_san_pham->comments->count()}})</a></li>
            <li><a href="#reviews" data-toggle="tab">Đánh giá ({{$phien_ban_san_pham->ratings->count()}})</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="active in tab-pane fade text-center" id="video_review">
            <form>
                @csrf
            <img src="{{asset('public/uploads/videos/'.$nhom_san_pham->video->image)}}" width="100%" height="300px">
            <!-- Button trigger modal -->
            <button type="button" id="{{$nhom_san_pham->video_id}}" class="btn btn-primary watch-video" data-toggle="modal" data-target="#video_modal">
                Click để xem
            </button>
            </form>
        </div>
        <div class="tab-pane fade" id="details">
            <h3>{{$nhom_san_pham->mo_ta_ngan_gon}}</h3>
            <p>{!! $nhom_san_pham->mo_ta_chi_tiet!!}</p>
        </div>

        <div class="tab-pane fade" id="companyprofile" >
            <h2>Cấu hình {{$phien_ban_san_pham->name}}</h2>
            <table class="technique_parameter">
                <thead>
                <tr>

                </tr>
                </thead>
                <tbody>
                @foreach($phien_ban_san_pham->product_specs as $spec)
                <tr>
                    <td>{{$spec->name}}</td>
                    <td>{{$spec->value}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade " id="comments" >
            <div class="col-sm-12">
                <div id="load-comment">

                </div>

                <p><b>Để lại bình luận</b></p>

                <form id="form-comment" action="#">
                    <span>
                        <input class="comment_name form-control" type="text" placeholder="Tên của bạn"/>
                        <input class="comment_email form-control" type="email" placeholder="Địa chỉ email"/>
                    </span>
                    <textarea class="comment_content form-control" rows="8" name="" ></textarea>
                    <button disabled id="btn-comment" type="button" class="btn btn-default pull-right send-comment">
                        Gửi
                    </button>
                    <div class="g-recaptcha" data-callback="recaptchaCallback1" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                    <br/>
                    @if($errors->has('g-recaptcha-response'))
                        <span class="invalid-feedback" style="display:block">
                        <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                    </span>
                    @endif
                    <div id="notify-comment">

                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade " id="reviews" >
            <div class="col-sm-12">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <div id="load-rating">

                </div>
                <h4><b>Để lại đánh giá của bạn</b></h4>
                <ul class="list-inline" title="Average Rating">
                    @for($count=1;$count<=5;$count++)

                    <li title="Đánh giá sao"
                    id="{{$phien_ban_san_pham->id}}-{{$count}}"
                    data-index="{{$count}}"
                    data-product_id="{{$phien_ban_san_pham->id}}"
                    data-rating="{{$rating}}"
                    class="rating"
                    style="cursor: pointer; {{$color}} font-size: 30px">
                    &#9733;
                    </li>
                    @endfor
                </ul>
                <form id="form-rating" action="#">
                    <span>
                        <input class="rating_name" type="text" placeholder="Tên của bạn"/>
                        <input class="rating_email" type="email" placeholder="Địa chỉ email"/>
                    </span>
                    <textarea class="rating_content" name="" ></textarea>
                    <button id="btn-rating" disabled type="button" class="btn btn-default pull-right send-rating">
                        Gửi
                    </button>
                    <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                    <br/>
                    @if($errors->has('g-recaptcha-response'))
                        <span class="invalid-feedback" style="display:block">
                        <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                    </span>
                    @endif
                    <div id="notify-rating">

                    </div>
                </form>
            </div>
        </div>
    </div>

</div><!--/category-tab-->
<div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="5"></div>
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm liên quan</h2>

    <div id="recommended-item-carousel">
        <div class="carousel-inner">
            <ul id="related_product">
                @foreach($san_phams_lien_quan as $key=>$san_pham)
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
    <!-- Modal xem video-->
    </div>
</div><!--/recommended_items-->
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
@endsection

@section('pagescript')


{{--    script load comment của sản phẩm, thêm comments--}}
    <script type="text/javascript">
        $(document).ready(function (){
            // var product_id = $('.product_id').val();
            // alert(product_id);
            load_comment();
            $('.send-comment').click(function (){
                var product_id = $('.product_id').val();
                var comment_name = $('.comment_name').val();
                var comment_email = $('.comment_email').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:'{{url('/send-comment')}}',
                    method:'POST',
                    data:{
                        product_id:product_id,
                        comment_name:comment_name,
                        comment_email:comment_email,
                        comment_content:comment_content,
                        _token:_token
                    },
                    success:function (data){
                        $('#form-comment')[0].reset();
                        $('#notify-comment').html('<span class="text text-success">Bình luận của bạn đang được duyệt</span>');
                        load_comment();
                        $('#notify-comment').fadeOut(5000);
                    }
                });
            });
            function load_comment(){
                var product_id = $('.product_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:'{{url('/load-comment')}}',
                    method:'POST',
                    data:{product_id:product_id,_token:_token},
                    success:function (data){
                        $('#load-comment').html(data);
                    }
                });
            }
        })
    </script>

{{--script cho slider sản phẩm liên quan--}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#related_product').lightSlider({
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

{{--script load rating và thêm rating    --}}
<script type="text/javascript">
    $(document).ready(function (){
        load_rating();
        function load_rating(){
            var product_id = $('.product_id').val();
            $.ajax({
                url:'{{url('/load-rating')}}',
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{product_id:product_id},
                success:function (data){
                    $('#load-rating').html(data);
                }
            });
        }

    function remove_background(product_id){
        for(var count=1;count<=5;count++){
            $('#'+product_id+'-'+count).css('color','#ccc');
        }
    }

    //hover chuột đánh giá sao
    $(document).on('click','.rating',function (){
       var index = $(this).data('index');
       var product_id = $(this).data('product_id');
       remove_background(product_id);
       //Đổi màu sao theo index đang hover vào
        for(var count=1;count<=index;count++){
            $('#'+product_id+'-'+count).css('color','#ffcc00');
        }
             $('#'+product_id+'-'+index).addClass('active-index');
    });

    //Nhả chuột không đánh giá
    // $(document).on('mouseleave','.rating',function (){
    //     var index = $(this).data('index');
    //     var product_id = $(this).data('product_id');
    //     var rating = $(this).data('rating');
    //     remove_background(product_id);
    //     //Đổi màu sao theo index đang hover vào
    //     for(var count=1;count<=rating;count++){
    //         $('#'+product_id+'-'+count).css('color','#ffcc00');
    //     }
    // });

    $(document).on('click','.send-rating',function (){
       var index = $('.active-index').data('index');
        var product_id = $('.product_id').val();
        var rating_name = $('.rating_name').val();
        var rating_email = $('.rating_email').val();
        var rating_content = $('.rating_content').val();


        $.ajax({
            url: "{{url('/insert-rating')}}",
            method: "POST",
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                index:index,
                product_id:product_id,
                rating_name:rating_name,
                rating_email:rating_email,
                rating_content:rating_content
            },
            success:function (data){
                if($.isEmptyObject(data.error)){
                    $("#form-rating")[0].reset();
                    $(".print-error-msg").css('display','none');
                    swal({
                        title: "Đánh giá thành công",
                        closeOnConfirm: false
                    },
                        function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        }
                    })
                }else{
                    swal({
                        title: "Vui lòng check captcha",
                        // text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                        // showCancelButton: true,
                        // cancelButtonText: "Tiếp tục",
                        // confirmButtonClass: "btn-success",
                        // confirmButtonText: "Đi đến giỏ hàng",
                        closeOnConfirm: false
                    })
                }
            }
        });
    });
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });
    function recaptchaCallback() {
        $('#btn-rating').removeAttr('disabled');
    };
    function recaptchaCallback1() {
        $('#btn-comment').removeAttr('disabled');
    };



</script>
{{--script check capcha cho đánh giá--}}
<script type="text/javascript">

</script>
@endsection



