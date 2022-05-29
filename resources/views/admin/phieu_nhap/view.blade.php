@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('view-phieu-nhap',$phieu_nhap) }}
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
                    Phiếu nhập #{{$phieu_nhap->id}}
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
                                            <h3 class="card-title">Thông tin cơ bản phiếu nhập</h3>
                                        </div>
                                        <div class="card-body">
                                            <!-- Date dd/mm/yyyy -->
                                            <div class="form-group">
                                                <label>Nhà cung cấp:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input class="form-control" type="text" disabled value="{{$phieu_nhap->nha_cung_cap->name}}">
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
                                                    <input disabled class="form-control" type="text" value="{{$phieu_nhap->name}}" name="name" placeholder="Nhập tên phiếu">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <label>Nội dung:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input disabled class="form-control" id="noi_dung" type="text" value="{{$phieu_nhap->content}}" name="noi_dung" placeholder="Nhập nội dung">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <div class="form-group">
                                                <label>Trạng thái:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input disabled class="form-control"  type="text" value="{{$phieu_nhap->trang_thai}}" name="trang_thai">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <!-- /.form group -->
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                    <!-- Thông tin chi tiết phiếu nhập -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Số lượng yêu cầu</th>
                                                    <th>Số lượng thực nhập</th>
                                                    <th>Giá nhập</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                                </thead>
                                                <tbody id="DynamicTable">
                                                @foreach($chi_tiet_phieu_nhap as $ctpn)
                                                <tr>
                                                    @php
                                                        $product = \App\Models\Product::find($ctpn->product_id);
                                                    @endphp
                                                    <td>
                                                        <input disabled value="{{$product->name}}" class="form-control" name="san_pham[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="number" value="{{$ctpn->so_luong_yeu_cau}}" class="form-control" name="so_luong_yeu_cau[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="number" value="{{$ctpn->so_luong_thuc_nhap}}" class="form-control so_luong" name="so_luong_thuc_nhap[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="text" value="{{number_format($ctpn->gia_nhap,0,",",".")}} đ" class="form-control gia_nhap" name="gia_nhap[]">
                                                    </td>
                                                    <td>
                                                        <input disabled type="text" value="{{number_format($ctpn->thanh_tien,0,",",".")}} đ" class="form-control thanh_tien" name="thanh_tien[]">
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <a href="{{route('print-phieu-nhap',['id'=>$phieu_nhap->id])}}"
                                               target="_blank"
                                               class="btn btn-primary btn-lg"
                                               onclick="return confirm('Việc xuất phiếu sẽ đặt trạng thái về xác nhận, điều đó có nghĩa bạn sẽ không thể sửa phiếu nhập nữa, bạn có muốn tiếp tục?')">Xuất phiếu nhập
                                            </a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        @if($phieu_nhap->trang_thai=="Chưa xác nhận")
                        <a href="{{route('edit-phieu-nhap',['id'=>$phieu_nhap->id])}}" class="active" ui-toggle-class="">
                            <span class="btn btn-primary">Sửa</span>
                        </a>
                        <a href="{{route('delete-phieu-nhap',['id'=>$phieu_nhap->id])}}"
                           onclick="return confirm('Bạn có chắc muốn xóa?')"
                           class="active" ui-toggle-class=""><span class="btn btn-danger">Xóa</span></a>
                        @endif
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection



