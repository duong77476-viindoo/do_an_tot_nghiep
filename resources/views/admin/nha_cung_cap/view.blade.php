@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($nha_cung_caps as $nha_cung_cap)
                    <header class="panel-heading">
                        {{$nha_cung_cap->name}}
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
                                <label for="exampleInputEmail1">Tên nhà cung cấp</label>
                                <input disabled value="{{$nha_cung_cap->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên nhà cung cấp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input disabled value="{{$nha_cung_cap->phone}}" type="text" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Nhập code">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input disabled value="{{$nha_cung_cap->address}}" type="text" class="form-control" id="exampleInputEmail1" name="address" placeholder="Nhập code">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số tài khoản</label>
                                <input disabled value="{{$nha_cung_cap->so_tai_khoan}}" type="text" class="form-control" id="exampleInputEmail1" name="so_tai_khoan" placeholder="Nhập code">
                            </div>

                            @endforeach
                        </div>
                    </div>
            </section>

        </div>
    </div>
@endsection
