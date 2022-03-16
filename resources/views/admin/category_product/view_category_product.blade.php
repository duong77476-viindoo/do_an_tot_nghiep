@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($category_product as $key=>$item)
                <header class="panel-heading">
                    {{$item->category_product_name}}
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
                            <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-category-product/'.$item->id)}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên phân loại</label>
                                    <input disabled type="text" value="{{$item->category_product_name}}" class="form-control" id="exampleInputEmail1" name="category_product_name" placeholder="Nhập phân loại">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh mục cha</label>
                                    <select disabled class="form-control" name="category_id">
                                        @foreach($categories as $key=>$category)
                                            <option {{$category->id==$item->category_id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea disabled style="resize: none"  class="form-control" id="exampleInputPassword1" name="category_product_desc">{{trim($item->category_product_desc)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta keywords</label>
                                    <input disabled type="text" value="{{$item->meta_keywords}}" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập từ khóa danh mục">
                                </div>
{{--                                <button type="submit"  name="add_category_product" class="btn btn-info">Cập nhật</button>--}}
                            </form>
                        </div>
                    <a href="{{route('edit-category-product',['id'=>$item->id])}}" class="active" ui-toggle-class="">
                       <span class="btn btn-primary">Sửa</span>
                    </a>
                    <a href="{{route('delete-category-product',['id'=>$item->id])}}"
                       onclick="return confirm('Bạn có chắc muốn xóa?')"
                       class="active" ui-toggle-class=""><span class="btn btn-danger">Xóa</span></a>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
@endsection
