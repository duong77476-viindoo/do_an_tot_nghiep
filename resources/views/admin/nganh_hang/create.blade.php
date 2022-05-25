@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add_nganh_hang') }}
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
                    Thêm ngành hàng
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
                        <form role="form" action="{{route('save-nganh-hang')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên ngành hàng</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên ngành hàng">
                            </div>
                            <button type="submit" name="add_nganh_hang" class="btn btn-info">Thêm</button>
                        </form>

                        <div>

                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
