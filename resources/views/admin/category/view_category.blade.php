@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('view_category',$category[0]) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($category as $key=>$item)
                <header class="panel-heading">
                    {{$item->name}}
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="panel-body">

                        <div class="position-center">
                            <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-category/'.$item->id)}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên loại phân loại</label>
                                    <input disabled type="text" value="{{$item->name}}" class="form-control" id="exampleInputEmail1" name="category_name" placeholder="Nhập phân loại">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea disabled style="resize: none"  class="form-control" id="exampleInputPassword1" name="category_desc">{{trim($item->desc)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta keywords</label>
                                    <input disabled type="text" value="{{$item->meta_keywords}}" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập từ khóa danh mục">
                                </div>
{{--                                <button type="submit"  name="add_category" class="btn btn-info">Cập nhật</button>--}}
                            </form>
                        </div>
                    <a href="{{route('edit-category',['id'=>$item->id])}}" class="active" ui-toggle-class="">
                       <span class="btn btn-primary">Sửa</span>
                    </a>
                    <a href="{{route('delete-category',['id'=>$item->id])}}"
                       onclick="return confirm('Bạn có chắc muốn xóa?')"
                       class="active" ui-toggle-class=""><span class="btn btn-danger">Xóa</span></a>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
@endsection
