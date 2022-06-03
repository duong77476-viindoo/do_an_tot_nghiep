@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add_customer') }}
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
                    Tạo mới khách hàng
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
                        <form role="form" action="{{route('save-customer')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên khách hàng</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Điện thoại</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Nhập điện thoại">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Điạ chỉ</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="address" placeholder="Nhập địa chỉ">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" class="form-control" id="exampleInputEmail1" name="password" placeholder="Nhập mật khẩu">
                            </div>
                            <button type="submit" name="add_admin" class="btn btn-info">Thêm mới</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
