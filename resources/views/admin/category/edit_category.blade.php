@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit_category',$category[0]) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa danh mục loại phân loại
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    @foreach($category as $key=>$item)
                    <div class="position-center">
                        <form role="form" action="{{route('update-category',['id'=>$item->id])}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên loại phân loại</label>
                                <input type="text" value="{{$item->name}}" class="form-control" id="exampleInputEmail1" name="category_name" placeholder="Nhập phân loại">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh mục ngành hàng</label>
                                <select class="form-control" name="nganh_hang_id">
                                    @foreach($nganh_hangs as $key=>$nganh_hang)
                                        <option {{$nganh_hang->id==$item->nganh_hang_id ? 'selected' : ''}} value="{{$nganh_hang->id}}">{{$nganh_hang->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả</label>
                                <textarea style="resize: none"  class="form-control" id="exampleInputPassword1" name="category_desc">{{trim($item->desc)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta keywords</label>
                                <input type="text" value="{{$item->meta_keywords}}" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập từ khóa danh mục">
                            </div>
                            <button type="submit"  name="add_category" class="btn btn-info">Cập nhật</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
@endsection
