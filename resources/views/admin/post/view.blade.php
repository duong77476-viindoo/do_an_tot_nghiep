@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($posts as $post)
                <header class="panel-heading">
                   {{$post->name}}
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
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề bài viết</label>
                                    <input disabled value="{{$post->title}}" type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="Nhập tiêu đề">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả bài viết</label>
                                    <input disabled value="{{$post->desc}}" type="text" class="form-control" id="exampleInputEmail1" name="desc" placeholder="Nhập mô tả">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung</label>
                                    <textarea disabled id="mo_ta_chi_tiet" style="resize: none" class="form-control" id="exampleInputPassword1" name="content" placeholder="Nhập nội dung">{{$post->content}}"</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta keywords</label>
                                    <input disabled value="{{$post->meta_keywords}}" type="text" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập từ khóa meta">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ảnh bài viết</label>
                                    <input disabled type="file" class="form-control" id="exampleInputEmail1" name="image" >
                                    <img src="{{\Illuminate\Support\Facades\URL::to('public/uploads/posts/'.$post->image)}}" height="100" width="100">
                                </div>

                                <div class="form-group">
                                    <label>Danh mục bài viết</label>
                                    <select disabled name="post_type_id" class="form-control">
                                        @foreach($post_types as $key=>$post_type)
                                            @if($post->post_type_id == $post_type->id)
                                                <option selected value="{{$post_type->id}}">{{$post_type->name}}</option>
                                            @else
                                                <option value="{{$post_type->id}}">{{$post_type->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                        @endforeach
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
