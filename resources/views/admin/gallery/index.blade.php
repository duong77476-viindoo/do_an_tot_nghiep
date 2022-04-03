@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục ảnh sản phẩm
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>

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
                        <th>Tên sản phẩm</th>
                        <th>Thư viện ảnh</th>
                        <th>Code sản phẩm</th>
                        <th>Hiển thị</th>
                        <th>Trạng thái</th>
                        <th>Giá bán</th>
                        <th>Ảnh đại diện</th>
                        <th>Thương hiệu</th>
                        <th>Phân loại</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$product->name}}</td>
                            <td><a href="{{route('add-gallery',['id'=>$product->id])}}"></a></td>
                            <td>{{$product->code}}</td>
                            <td><span class="text-ellipsis">
                                @if($product->an_hien==0)
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/unactive-product/'.$product->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                    @else
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/active-product/'.$product->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                    @endif
                            </span>
                            <td><span class="text-ellipsis">
                                @if($product->trang_thai==0)
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/het-product/'.$product->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                    @else
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/con-product/'.$product->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                    @endif
                            </span>
                            </td>
                            <td>{{$product->gia_ban}}</td>
                            <td><img src="public/uploads/products/{{$product->anh_dai_dien}}" height="100" width="100"></td>
                            <td>{{$product->brand->brand_name}}</td>
                            <td>
                                @foreach($product->category_products as $category)
                                    <p>{{$category->category_product_name}}</p>
                                @endforeach
                            </td>

                            <td><span class="text-ellipsis">{{$product->updated_at}}</span></td>
                            <td>
                                <a href="{{route('edit-product',['id'=>$product->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-product',['id'=>$product->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-product',['id'=>$product->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-eye text-success text-active"></i>
                                </a>
                            </td>
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
                            {{ $products->links() }}
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
