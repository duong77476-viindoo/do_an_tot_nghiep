@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('brand') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục thương hiệu
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-4">
                    <a href="{{route('add-brand')}}"><span class="btn btn-primary fa fa-plus">Thêm thương hiệu</span></a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên thương hiệu</th>
                        <th>Slug thương hiệu</th>
                        <th>Hiển thị</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $key => $brand)
                        <tr>
                            <td>{{$brand->brand_name}}</td>
                            <td>{{$brand->brand_slug}}</td>
                            <td><span class="text-ellipsis">
                                @if($brand->brand_status==0)
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/unactive-brand/'.$brand->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                    @else
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/active-brand/'.$brand->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                    @endif
                            </span>
                            </td>
                            <td><span class="text-ellipsis">{{$brand->updated_at}}</span></td>
                            <td>
                                <a href="{{route('edit-brand',['id'=>$brand->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-brand',['id'=>$brand->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-brand',['id'=>$brand->id])}}" class="active" ui-toggle-class="">
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
