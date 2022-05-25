@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('category') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục loại phân loại
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-6">
                    <a href="{{route('add-category')}}"><span class="btn btn-primary fa fa-plus">Thêm phân loại</span></a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <th>Tên loại phân loại</th>
                        <th>Ngành hàng</th>
                        <th>Code</th>
                        <th>Từ khóa danh mục</th>
                        <th>Hiển thị</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $key => $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->nganh_hang->name}}</td>
                        <td>{{$category->code}}</td>
                        <td>{{$category->meta_keywords}}</td>
                        <td><span class="text-ellipsis">
                                @if($category->status==0)
                                    <a href="{{\Illuminate\Support\Facades\URL::to('/unactive-category/'.$category->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                @else
                                    <a href="{{\Illuminate\Support\Facades\URL::to('/active-category/'.$category->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                @endif
                            </span>
                        </td>
                        <td><span class="text-ellipsis">{{$category->updated_at}}</span></td>
                        <td>
                            <a href="{{route('edit-category',['id'=>$category->id])}}" class="active" ui-toggle-class="">
                                <i class="fa fa-pen text-success text-active"></i>
                            </a>
                            <a href="{{route('delete-category',['id'=>$category->id])}}"
                               onclick="return confirm('Bạn có chắc muốn xóa?')"
                               class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                            <a href="{{route('view-category',['id'=>$category->id])}}" class="active" ui-toggle-class="">
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
                            {{ $categories->links() }}
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
