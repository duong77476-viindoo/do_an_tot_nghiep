@extends('admin.admin_layout')
@section('admin_content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('view_user',$admin) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Người dùng : {{$admin->name}}
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
                                <label for="exampleInputEmail1">Tên người dùng</label>
                                <input disabled value="{{$admin->name}}"  type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên người dùng">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input disabled value="{{$admin->email}}" type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Điện thoại</label>
                                <input disabled value="{{$admin->phone}}" type="text" class="form-control" id="exampleInputEmail1" name="phone" placeholder="Nhập điện thoại">
                            </div>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
