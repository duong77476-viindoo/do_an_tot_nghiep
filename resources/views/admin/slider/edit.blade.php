@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit-slider',$sliders[0]) }}
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
                    Cập nhật slider
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
                        @foreach($sliders as $slider)
                        <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-slider/'.$slider->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên slider</label>
                                <input value="{{$slider->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên slider">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <input value="{{$slider->desc}}"  type="text" class="form-control" id="exampleInputEmail1" name="desc" placeholder="Nhập mô tả slider">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link slider</label>
                                <input value="{{$slider->link}}"  type="text" class="form-control" id="exampleInputEmail1" name="link" placeholder="Nhập link khi click slider">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh slider</label>
                                <input type="file" class="form-control" id="exampleInputEmail1" name="image" >
                                <img src="{{\Illuminate\Support\Facades\URL::to('public/uploads/sliders/'.$slider->image)}}" height="100" width="100">
                            </div>


                            <button type="submit" name="add_slider" class="btn btn-info">Cập nhật</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
