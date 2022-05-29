@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add-category-product')}}
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục phân loại
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
                    <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/save-category-product')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên phân loại</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="category_product_name" placeholder="Nhập phân loại">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục cha</label>
                            <select class="form-control" name="category_id">
                                @foreach($categories as $key=>$category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea style="resize: none" class="form-control" id="exampleInputPassword1" name="category_product_desc" placeholder="Mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta keywords</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập phân loại">
                        </div>
                       <div class="form-group">
                           <div class="radio">
                               <label>
                                   <input type="radio" name="category_product_status" id="optionsRadios1" value="0" checked="">
                                  Ẩn
                               </label>
                           </div>
                           <div class="radio">
                               <label>
                                   <input type="radio" name="category_product_status" id="optionsRadios2" value="1">
                                   Hiện
                               </label>
                           </div>
                       </div>
                        <button type="submit" name="add_category_product" class="btn btn-info">Thêm</button>
                    </form>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection
