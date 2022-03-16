@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($post_type as $key=>$item)
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
                            <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-post-type/'.$item->id)}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                                    <input disabled type="text" value="{{$item->name}}" class="form-control" id="exampleInputEmail1" name="post_type_name" placeholder="Nhập phân loại">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea disabled style="resize: none"  class="form-control" id="exampleInputPassword1" name="post_type_desc">{{trim($item->desc)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta keywords</label>
                                    <input disabled type="text" value="{{$item->meta_keywords}}" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập từ khóa danh mục">
                                </div>
{{--                                <button type="submit"  name="add_post_type" class="btn btn-info">Cập nhật</button>--}}
                            </form>
                        </div>
                    <a href="{{route('edit-post-type',['id'=>$item->id])}}" class="active" ui-toggle-class="">
                       <span class="btn btn-primary">Sửa</span>
                    </a>
                    <a href="{{route('delete-post-type',['id'=>$item->id])}}"
                       onclick="return confirm('Bạn có chắc muốn xóa?')"
                       class="active" ui-toggle-class=""><span class="btn btn-danger">Xóa</span></a>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
@endsection
