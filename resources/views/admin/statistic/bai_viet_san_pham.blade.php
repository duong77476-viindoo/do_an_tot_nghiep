@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-md-12">
            <h2>Thống kê sản phẩm, bài viết</h2>
            <div id="stat-donut" style="height: 300px"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>fsdfdf</h2>
            <ol>
                @foreach($post_views as $post_view)
                    <li>
                        <a target="_blank" href="{{route('chi-tiet-bai-viet',['danh_muc'=>$post_view->post_type->code,'bai_viet'=>$post_view->code])}}">
                            {{$post_view->title}} | <span style="color: black">{{$post_view->views}}</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
        <div class="col-md-6">
            <h2>Sản phẩm xem nhiều</h2>
            <ol>
                @foreach($product_views as $product_view)
                    <li>
                        <a target="_blank" href="{{route('product',['code'=>$product_view->code])}}">
                            {{$product_view->name}} | <span style="color: black">{{$product_view->views}}</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection

@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function (){
            Morris.Donut({
                element: 'stat-donut',
                resize: true,
                colors: [
                   '#ce616a',
                    '#61a1ce',
                    '#ce8f61',
                    '#f5b942',
                    '#4842f5'
                ],
                //labelColor:"#cccccc", // text color
                //backgroundColor: '#333333', // border color
                data: [
                    {label:"Sản phẩm", value:{{$product}} },
                    {label:"Bài viết", value:{{$post}} },
                    {label:"Đơn hàng", value:{{$order}} },
                    {label:"Video", value:{{$video}} },
                    {label:"Khách hàng", value:{{$customer}} }
                ]
            });

        })
    </script>
@endsection
