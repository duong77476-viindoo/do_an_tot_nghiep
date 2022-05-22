@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm loại phân loại
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
                    <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/save-category')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên loại phân loại</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="category_name" placeholder="Nhập phân loại">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục ngành hàng</label>
                            <select class="form-control" name="nganh_hang_id">
                                @foreach($nganh_hangs as $key=>$nganh_hang)
                                    <option value="{{$nganh_hang->id}}">{{$nganh_hang->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea style="resize: none" class="form-control" id="exampleInputPassword1" name="category_desc" placeholder="Mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta keywords</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="meta_keywords" placeholder="Nhập phân loại">
                        </div>
                       <div class="form-group">
                           <div class="radio">
                               <label>
                                   <input type="radio" name="category_status" id="optionsRadios1" value="0" >
                                  Ẩn
                               </label>
                           </div>
                           <div class="radio">
                               <label>
                                   <input type="radio" name="category_status" id="optionsRadios2" value="1" checked="">
                                   Hiện
                               </label>
                           </div>
                       </div>
                        <button type="submit" name="add_category" class="btn btn-info">Thêm</button>
                    </form>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection
