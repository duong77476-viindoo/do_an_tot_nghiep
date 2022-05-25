@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit-post',$post) }}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm bài viết
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
                        <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-post/'.$post->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề bài viết</label>
                                <input value="{{$post->title}}" type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="Nhập tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả bài viết</label>
                                <input value="{{$post->desc}}" type="text" class="form-control" id="exampleInputEmail1" name="desc" placeholder="Nhập mô tả">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung</label>
                                <textarea id="mo_ta_chi_tiet" style="resize: none" class="form-control" id="exampleInputPassword1" name="content" placeholder="Nhập nội dung">{{$post->content}}"</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta keywords</label>
                                <input value="{{$post->meta_keywords}}" type="text" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập từ khóa meta">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh bài viết</label>
                                <input type="file" class="form-control" id="exampleInputEmail1" name="image" >
                                <img src="{{\Illuminate\Support\Facades\URL::to('public/uploads/posts/'.$post->image)}}" height="100" width="100">
                            </div>

                            <div class="form-group">
                                <label>Danh mục bài viết</label>
                                <select name="post_type_id" class="form-control">
                                    @foreach($post_types as $key=>$post_type)
                                        @if($post->post_type_id == $post_type->id)
                                            <option selected value="{{$post_type->id}}">{{$post_type->name}}</option>
                                        @else
                                            <option value="{{$post_type->id}}">{{$post_type->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" name="add_post" class="btn btn-info">Cập nhật</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
