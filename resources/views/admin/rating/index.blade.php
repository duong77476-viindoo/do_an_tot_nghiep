@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('rating') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục đánh giá sản phẩm
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Sản phẩm</th>
                        <th>Nội dung đánh giá</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số sao</th>
                        <th>Ngày cập nhật</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ratings as $key => $rating)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="rating[]"><i></i></label></td>
                            <td><a href="{{route('product',['code'=>$rating->product->code])}}">{{$rating->product->name}}</a></td>
                            <td>{{$rating->content}}</td>
                            <td>{{$rating->name}}</td>
                            <td>{{$rating->email}}</td>
                            <td>{{$rating->rating}}</td>
                            <td>{{$rating->updated_at}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    {{--                    <div class="col-sm-5 text-center">--}}
                    {{--                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>--}}
                    {{--                    </div>--}}
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $ratings->links() }}
                            {{--                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>--}}
                            {{--                            <li><a href="">1</a></li>--}}
                            {{--                            <li><a href="">2</a></li>--}}
                            {{--                            <li><a href="">3</a></li>--}}
                            {{--                            <li><a href="">4</a></li>--}}
                            {{--                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>--}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
