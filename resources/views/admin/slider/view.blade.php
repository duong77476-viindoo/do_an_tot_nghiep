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
                @foreach($sliders as $slider)
                <header class="panel-heading">
                    {{$slider->name}}
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
                                    <label for="exampleInputEmail1">Tên slider</label>
                                    <input disabled value="{{$slider->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên slider">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <input disabled value="{{$slider->desc}}"  type="text" class="form-control" id="exampleInputEmail1" name="desc" placeholder="Nhập mô tả slider">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Link slider</label>
                                    <input disabled value="{{$slider->link}}"  type="text" class="form-control" id="exampleInputEmail1" name="link" placeholder="Nhập link khi click slider">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ảnh slider</label>
                                    <input disabled type="file" class="form-control" id="exampleInputEmail1" name="image" >
                                    <img src="{{\Illuminate\Support\Facades\URL::to('public/uploads/sliders/'.$slider->image)}}" height="100" width="100">
                                </div>

                        @endforeach
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
