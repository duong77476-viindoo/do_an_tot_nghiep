@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit_provider',$nha_cung_caps[0]) }}
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
                    Sửa nhà cung cấp
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
                        @foreach($nha_cung_caps as $nha_cung_cap)
                            <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-nha-cung-cap/'.$nha_cung_cap->id)}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên nhà cung cấp</label>
                                    <input value="{{$nha_cung_cap->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên nhà cung cấp">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input value="{{$nha_cung_cap->phone}}" type="text" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Nhập code">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Địa chỉ</label>
                                    <input value="{{$nha_cung_cap->address}}" type="text" class="form-control" id="exampleInputEmail1" name="address" placeholder="Nhập code">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tài khoản</label>
                                    <input value="{{$nha_cung_cap->so_tai_khoan}}" type="text" class="form-control" id="exampleInputEmail1" name="so_tai_khoan" placeholder="Nhập code">
                                </div>
                                <button type="submit" name="add_nha_cung_cap" class="btn btn-info">Cập nhật</button>
                            </form>
                        @endforeach
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
