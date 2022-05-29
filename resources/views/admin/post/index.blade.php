@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('post') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Toàn bộ bài viết
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
                    <a href="{{route('add-post')}}"><span class="btn btn-primary fa fa-plus">Thêm bài viết</span></a>
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
                        <th>Tiêu đề bài viết</th>
                        <th>Code bài viết</th>
                        <th>Hiển thị</th>
                        <th>Mô tả</th>
                        <th>Ảnh</th>
                        <th>Danh mục</th>
                        <th>Ngày cập nhật</th>
                        <th>Người cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $key => $post)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->code}}</td>
                            <td><span class="text-ellipsis">
                                @if($post->status==0)
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/unactive-post/'.$post->id)}}"><span class="text-danger fa fa-times-circle"></span></a>
                                    @else
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/active-post/'.$post->id)}}"><span class="text-success fa fa-check-circle"></span></a>
                                    @endif
                            </span>
                            <td>{{$post->desc}}</td>
                            <td><img src="public/uploads/posts/{{$post->image}}" height="100" width="100"></td>
                            <td>{{$post->post_type->name}}</td>
                            <td><span class="text-ellipsis">{{$post->updated_at}}</span></td>
                            <td><span class="text-ellipsis">{{$post->nguoi_sua}}</span></td>
                            <td>
                                <a href="{{route('edit-post',['id'=>$post->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-post',['id'=>$post->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-post',['id'=>$post->id])}}" class="active" ui-toggle-class="">
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
