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
                    Thêm slider
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
                        <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/save-slider')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên slider</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên slider">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="desc" placeholder="Nhập mô tả slider">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link slider</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="link" placeholder="Nhập link khi click slider">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh slider</label>
                                <input type="file" class="form-control" id="exampleInputEmail1" name="image" >
                            </div>

                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="an_hien" id="optionsRadios1" value="0" checked="">
                                            Ẩn
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="an_hien" id="optionsRadios2" value="1">
                                            Hiện
                                        </label>
                                    </div>
                                </div>
                            <button type="submit" name="add_slider" class="btn btn-info">Thêm</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
