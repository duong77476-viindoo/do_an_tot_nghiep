@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('view_customer',$customer) }}
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
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên khách hàng</label>
                                <input readonly value="{{$customer->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên khách hàng">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input readonly value="{{$customer->email}}" type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Điện thoại</label>
                                <input readonly value="{{$customer->phone}}" type="text" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Nhập điện thoại">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Điạ chỉ</label>
                                <input readonly value="{{$customer->address}}" type="text" class="form-control" id="exampleInputEmail1" name="address" placeholder="Nhập địa chỉ">
                            </div>
                    </div>
                    <a href="{{route('edit-customer',['id'=>$customer->id])}}" class="active" ui-toggle-class="">
                        <span class="btn btn-primary">Sửa</span>
                    </a>
                    <a href="{{route('delete-customer',['id'=>$customer->id])}}"
                       onclick="return confirm('Bạn có chắc muốn xóa?')"
                       class="active" ui-toggle-class=""><span class="btn btn-danger">Xóa</span></a>
                </div>
            </section>

        </div>
    </div>

@endsection
