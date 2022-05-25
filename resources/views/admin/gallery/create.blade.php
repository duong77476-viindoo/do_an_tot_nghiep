@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add-gallery',$product_group) }}
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
                    Thêm thư viện ảnh cho <span class="text-primary">sản phẩm {{$product_group->name}}</span>
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <form action="{{route('insert-gallery',['id'=>$product_group->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="file[]" id="file" accept="image/*" multiple>
                            <span id="error_gallery"></span>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" name="upload" value="Tải ảnh" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                <div class="panel-body">
                    <div class="position-center">
                        <input type="hidden" value="{{$product_group->id}}" name="product_group_id" class="product_group_id">
                        <form>
                            @csrf
                        <div id="load-gallery">
                        </div>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
