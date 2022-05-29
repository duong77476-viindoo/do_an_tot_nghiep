@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit-post-type',$post_type[0]) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa danh mục bài viết
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    @foreach($post_type as $key=>$item)
                    <div class="position-center">
                        <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-post-type/'.$item->id)}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                                <input type="text" value="{{$item->name}}" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập danh mục phân loại">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả</label>
                                <textarea style="resize: none"  class="form-control" id="exampleInputPassword1" name="desc">{{trim($item->desc)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta keywords</label>
                                <input type="text" value="{{$item->meta_keywords}}" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập từ khóa danh mục">
                            </div>
                            <button type="submit"  name="add_post-type" class="btn btn-info">Cập nhật</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
@endsection
