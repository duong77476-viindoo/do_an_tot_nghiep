@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit_user',$admin) }}
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
                    Cập nhật người dùng
                </header>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-admin/'.$admin->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên người dùng</label>
                                <input value="{{$admin->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên người dùng">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input value="{{$admin->email}}" type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Điện thoại</label>
                                <input value="{{$admin->phone}}" type="text" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Nhập điện thoại">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhập password hiện tại</label>
                                <input  type="password" class="form-control" id="exampleInputEmail1" name="current_password" placeholder="Nhập mật khẩu cũ">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhập password mới</label>
                                <input  type="password" class="form-control" id="exampleInputEmail1" name="new_password" placeholder="Nhập mật khẩu mới">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Xác nhận password</label>
                                <input  type="password" class="form-control" id="exampleInputEmail1" name="new_password_confirm" placeholder="Xác nhận mật khẩu mới">
                            </div>
                            <button type="submit" name="add_admin" class="btn btn-info">Cập nhật</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
