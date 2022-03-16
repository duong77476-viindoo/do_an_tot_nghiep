@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa thương hiệu
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    @foreach($brand as $key=>$item)
                        <div class="position-center">
                            <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-brand/'.$item->id)}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" value="{{$item->brand_name}}" class="form-control" id="exampleInputEmail1" name="brand_name" placeholder="Nhập thương hiệu">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none"  class="form-control" id="exampleInputPassword1" name="brand_desc">{{trim($item->brand_desc)}}</textarea>
                                </div>
                                <button type="submit"  name="add_brand" class="btn btn-info">Cập nhật</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
@endsection
