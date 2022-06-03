@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('slider') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục slider
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
                    <a href="{{route('add-slider')}}"><span class="btn btn-primary fa fa-plus">Thêm slider</span></a>
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
                        <th>Tên slider</th>
                        <th>Mô tả</th>
                        <th>Ẩn/hiện</th>
                        <th>Link</th>
                        <th>Hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sliders as $key => $slider)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$slider->name}}</td>
                            <td>{{$slider->desc}}</td>
                            <td><span class="text-ellipsis">
                                @if($slider->an_hien==0)
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/unactive-slider/'.$slider->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                    @else
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/active-slider/'.$slider->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                    @endif
                            </span>
                            <td>{{$slider->link}}</td>
                            <td><img src="public/uploads/sliders/{{$slider->image}}" height="100" width="100"></td>
                            <td>
                                <a href="{{route('edit-slider',['id'=>$slider->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-slider',['id'=>$slider->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-slider',['id'=>$slider->id])}}" class="active" ui-toggle-class="">
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
