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
                    Thêm thanh toán công nợ NCC
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
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="{{route('save-thanh-toan-cong-no')}}" method="post" >
                                    {{csrf_field()}}
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin phiếu thanh toán</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Date dd/mm/yyyy -->
                                        <div class="form-group">
                                            <label>Nhà cung cấp:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                                <select name="nha_cung_cap_id" id="nha_cung_cap_id" class="form-control">
{{--                                                    <option value="">---Chọn---</option>--}}
                                                @foreach($nha_cung_caps as $key=>$nha_cung_cap)
                                                        <option value="{{$nha_cung_cap->id}}">{{$nha_cung_cap->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label>Nội dung:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                                <input class="form-control" id="noi_dung" type="text" name="noi_dung" placeholder="Nhập nội dung">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group">
                                            <label>Số tiền:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                                <input class="form-control" id="so_tien" type="number" name="so_tien" placeholder="Nhập số tiền">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                    <input type="submit" class="btn btn-primary form-control" value="Xác nhận và lưu">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection




