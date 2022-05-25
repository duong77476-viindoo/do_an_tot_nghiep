@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('view-coupon',$coupon[0]) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($coupon as $key=>$item)
                <header class="panel-heading">
                    {{$item->name}}
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

                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                    <input disabled value="{{$item->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên mã giảm giá">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã giảm giá</label>
                                    <input disabled value="{{$item->code}}" type="text" class="form-control" id="exampleInputEmail1" name="code" placeholder="Mã giảm giá">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng mã</label>
                                    <input disabled value="{{$item->so_luong}}" type="number" class="form-control" id="exampleInputEmail1" name="so_luong" placeholder="Số lượng mã">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tính năng mã</label>
                                    <select disabled name="tinh_nang" class="form-control">
                                        @if($item->tinh_nang==1)
                                            <option value="1" selected>Giảm theo phần trăm</option>
                                            <option value="2" >Giảm theo tiền</option>
                                        @else
                                            <option value="1" >Giảm theo phần trăm</option>
                                            <option value="2" selected>Giảm theo tiền</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số % hoặc tiền giảm</label>
                                    <input disabled  value="{{$item->tien_giam}}" type="text" class="form-control" id="exampleInputEmail1" name="tien_giam" placeholder="Nhập số % hoặc tiền giảm">
                                </div>

                        </div>

                </div>
                @endforeach
            </section>

        </div>
    </div>
@endsection
