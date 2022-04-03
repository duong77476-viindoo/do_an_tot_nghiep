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
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa ngành hàng
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
                        @foreach($nganh_hangs as $nganh_hang)
                            <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-nganh-hang/'.$nganh_hang->id)}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên ngành hàng</label>
                                    <input value="{{$nganh_hang->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên ngành hàng">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Code ngành hàng</label>
                                    <input value="{{$nganh_hang->code}}" type="text" class="form-control" id="exampleInputEmail1" name="code" placeholder="Nhập code">
                                </div>
                                <button type="submit" name="add_nganh_hang" class="btn btn-info">Cập nhật</button>
                            </form>
                        @endforeach
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
