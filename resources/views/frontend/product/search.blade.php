@extends('frontend.layout')
@section('content')
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Kết quả cho <span class="text-success">{{$tu_khoa}}</span></h2>
        @foreach($san_pham_tim_kiem as $san_pham)
            <a href="{{route('product',['code'=>$san_pham->code])}}">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{url('public/uploads/products/'.$san_pham->anh_dai_dien)}}" alt="" />
                                <h2>{{number_format($san_pham->gia_ban,0,'','.')}} đ</h2>
                                <p>{{$san_pham->name}}</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
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
