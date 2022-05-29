@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('view-phieu-xuat',$phieu_xuat) }}
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
                    Phiếu xuất #{{$phieu_xuat->id}} (Đơn hàng# <a href="{{route('view-customer-order',['id'=>$phieu_xuat->order_id])}}">{{$phieu_xuat->order_id}}</a>)
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
                                    <div class="card card-danger">
                                        <div class="card-header">
                                            <h3 class="card-title">Thông tin cơ bản Phiếu xuất</h3>
                                        </div>
                                        <div class="card-body">
                                            <!-- Date dd/mm/yyyy -->
                                            <div class="form-group">
                                                <label>Đơn hàng:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input class="form-control" type="text" disabled value="{{$phieu_xuat->order_id}}">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->


                                            <!-- phone mask -->
                                            <div class="form-group">
                                                <label>Tên phiếu:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input disabled class="form-control" type="text" value="{{$phieu_xuat->name}}" name="name" placeholder="Nhập tên phiếu">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <label>Nội dung:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input disabled class="form-control" id="noi_dung" type="text" value="{{$phieu_xuat->content}}" name="noi_dung" placeholder="Nhập nội dung">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <label>Trạng thái:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input disabled class="form-control"  type="text" value="{{$phieu_xuat->trang_thai}}" name="trang_thai">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                    <!-- Thông tin chi tiết Phiếu xuất -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Số lượng yêu cầu</th>
                                                    <th>Số lượng thực xuất</th>
                                                    <th>Giá xuất</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                                </thead>
                                                <tbody id="DynamicTable">
                                                @foreach($chi_tiet_phieu_xuat as $ctpx)
                                                <tr>
                                                    @php
                                                        $product = \App\Models\Product::find($ctpx->product_id);
                                                    @endphp
                                                    <td>
                                                        <input disabled value="{{$product->name}}" class="form-control" name="san_pham[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="number" value="{{$ctpx->so_luong_yeu_cau}}" class="form-control" name="so_luong_yeu_cau[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="number" value="{{$ctpx->so_luong_thuc_xuat}}" class="form-control so_luong" name="so_luong_thuc_xuat[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="text" value="{{number_format($ctpx->gia_xuat,0,",",".")}} đ" class="form-control gia_xuat" name="gia_xuat[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="text" value="{{number_format($ctpx->thanh_tien,0,",",".")}} đ" class="form-control thanh_tien" name="thanh_tien[]">
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <a href="{{route('print-phieu-xuat',['id'=>$phieu_xuat->id])}}" target="_blank" class="btn btn-primary btn-lg">Xuất Phiếu xuất</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection



