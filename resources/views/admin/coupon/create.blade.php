@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add-coupon') }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm danh mục coupon, mã giảm giá
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
                        <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/save-coupon')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên mã giảm giá">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mã giảm giá</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="code" placeholder="Mã giảm giá">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số lượng mã</label>
                                <input type="number" class="form-control" id="exampleInputEmail1" name="so_luong" placeholder="Số lượng mã">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tính năng mã</label>
                                <select name="tinh_nang" class="form-control">
                                    <option value="0">---Chọn----</option>
                                    <option value="1">Giảm theo phần trăm</option>
                                    <option value="2">Giảm theo tiền</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số % hoặc tiền giảm</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="tien_giam" placeholder="Nhập số % hoặc tiền giảm">
                            </div>
                            <button type="submit" name="add_coupon" class="btn btn-info">Thêm</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>
@endsection
