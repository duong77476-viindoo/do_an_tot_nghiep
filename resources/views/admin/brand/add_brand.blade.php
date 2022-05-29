@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add-brand') }}
    <div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục thương hiệu
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
                    <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/save-brand')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="brand_name" placeholder="Nhập tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea style="resize: none" class="form-control" id="exampleInputPassword1" name="brand_desc" placeholder="Mô tả"></textarea>
                        </div>
                       <div class="form-group">
                           <div class="radio">
                               <label>
                                   <input type="radio" name="brand_status" id="optionsRadios1" value="0" >
                                  Ẩn
                               </label>
                           </div>
                           <div class="radio">
                               <label>
                                   <input type="radio" name="brand_status" id="optionsRadios2" value="1" checked="">
                                   Hiện
                               </label>
                           </div>
                       </div>
                        <button type="submit" name="add_brand" class="btn btn-info">Thêm</button>
                    </form>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection
