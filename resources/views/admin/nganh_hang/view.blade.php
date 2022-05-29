@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('view_nganh_hang',$nganh_hang) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">

                    <header class="panel-heading">
                        {{$nganh_hang->name}}
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
                                <label for="exampleInputEmail1">Tên ngành hàng</label>
                                <input disabled value="{{$nganh_hang->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Code ngành hàng</label>
                                <input disabled value="{{$nganh_hang->code}}" type="text" class="form-control" id="exampleInputEmail1" name="code">
                            </div>
                        </div>
                        <a href="{{route('edit-nganh-hang',['id'=>$nganh_hang->id])}}" class="active" ui-toggle-class="">
                            <span class="btn btn-primary">Sửa</span>
                        </a>
                        <a href="{{route('delete-nganh-hang',['id'=>$nganh_hang->id])}}"
                           onclick="return confirm('Bạn có chắc muốn xóa?')"
                           class="active" ui-toggle-class=""><span class="btn btn-danger">Xóa</span></a>
                    </div>
            </section>

        </div>
    </div>
@endsection
