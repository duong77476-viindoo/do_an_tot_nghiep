@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('product') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục nhóm sản phẩm
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
                <div class="col-sm-4">
                    <a href="{{route('add-product')}}"><span class="btn btn-primary fa fa-plus">Thêm nhóm sản phẩm</span></a>
                </div>
{{--                <div class="col-sm-3">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" class="input-sm form-control" placeholder="Search">--}}
{{--                        <span class="input-group-btn">--}}
{{--            <button class="btn btn-sm btn-default" type="button">Go!</button>--}}
{{--          </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên nhóm sản phẩm</th>
                        <th>Thư viện ảnh</th>
                        <th>Phiên bản sản phẩm</th>
                        <th>Slug sản phẩm</th>
                        <th>Hiển thị</th>
                        <th>Trạng thái</th>
                        <th>Ảnh đại diện</th>
                        <th>Phân loại</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product_groups as $key => $product_group)
                        <tr>
                            <td>{{$product_group->name}}</td>
                            <td><a href="{{route('add-gallery',['id'=>$product_group->id])}}">Thêm thư viện ảnh</a></td>
                            <td><a href="{{route('add-product-spec',['id'=>$product_group->id])}}">Thêm phiên bản</a></td>
                            <td>{{$product_group->code}}</td>
                            <td><span class="text-ellipsis">
                                @if($product_group->an_hien==0)
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/unactive-product_group/'.$product_group->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                    @else
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/active-product_group/'.$product_group->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                    @endif
                            </span></td>
                            <td><span class="text-ellipsis">
                                @if($product_group->trang_thai==0)
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/het-product_group/'.$product_group->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                    @else
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/con-product_group/'.$product_group->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                    @endif
                            </span>
                            </td>
                            <td><img src="public/uploads/products/{{$product_group->anh_dai_dien}}" height="100" width="100"></td>
                            <td>
                                @foreach($product_group->category_products as $category)
                                    <p>{{$category->category_product_name}}</p>
                                @endforeach
                            </td>
                            <td><span class="text-ellipsis">{{$product_group->updated_at}}</span></td>
                            <td>
                                <a href="{{route('edit-product',['id'=>$product_group->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-product',['id'=>$product_group->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-product',['id'=>$product_group->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-eye text-success text-active"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
