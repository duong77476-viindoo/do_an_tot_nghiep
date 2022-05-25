@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('category-product') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục phân loại sản phẩm
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-3 m-b-xs">
                    <form action="{{route('category-import-csv')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".xlsx"><br>
                        <input type="submit" value="Nhập file excel" name="import_csv" class="btn btn-warning">
                    </form>
                </div>
                <div class="col-sm-2">
                    <form action="{{route('category-export-csv')}}" method="POST">
                        @csrf
                        <input type="submit" value="Xuất file excel" name="export_csv" class="btn btn-success">
                    </form>
                </div>
                <div class="col-sm-4">
                    <a href="{{route('add-category-product')}}"><span class="btn btn-primary fa fa-plus">Thêm phân loại</span></a>
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
                        <th>Tên phân loại</th>
                        <th>Danh mục cha</th>
                        <th>Từ khóa danh mục</th>
                        <th>Hiển thị</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category_products as $key => $category_product)
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{$category_product->category_product_name}}</td>
                        <td>{{$category_product->category->name}}</td>
                        <td>{{$category_product->meta_keywords}}</td>
                        <td><span class="text-ellipsis">
                                @if($category_product->category_product_status==0)
                                    <a href="{{\Illuminate\Support\Facades\URL::to('/unactive-category-product/'.$category_product->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                @else
                                    <a href="{{\Illuminate\Support\Facades\URL::to('/active-category-product/'.$category_product->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                @endif
                            </span>
                        </td>
                        <td><span class="text-ellipsis">{{$category_product->updated_at}}</span></td>
                        <td>
                            <a href="{{route('edit-category-product',['id'=>$category_product->id])}}" class="active" ui-toggle-class="">
                                <i class="fa fa-pen text-success text-active"></i>
                            </a>
                            <a href="{{route('delete-category-product',['id'=>$category_product->id])}}"
                               onclick="return confirm('Bạn có chắc muốn xóa?')"
                               class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                            <a href="{{route('view-category-product',['id'=>$category_product->id])}}" class="active" ui-toggle-class="">
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
                            {{ $category_products->links() }}
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
