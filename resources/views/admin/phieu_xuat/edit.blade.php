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
                    Phiếu xuất #{{$phieu_xuat->id}}
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
                                <form role="form" action="{{route('update-phieu-xuat',['id'=>$phieu_xuat->id])}}" method="post" >
                                    {{csrf_field()}}
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
                                                <input readonly class="form-control" type="text" name="order_id" value="{{$phieu_xuat->order_id}}">
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
                                                <input  class="form-control" type="text" value="{{$phieu_xuat->name}}" name="name" placeholder="Nhập tên phiếu">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group">
                                            <label>Nội dung:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                                <input  class="form-control" id="noi_dung" type="text" value="{{$phieu_xuat->content}}" name="noi_dung" placeholder="Nhập nội dung">
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
                                                        <select readonly="" class="form-control" name="san_pham[]">
                                                            @foreach($products as $product)
                                                                @if($product->id == $ctpx->product_id)
                                                                    <option value="{{$product->id}}">{{$product->code}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input  type="number" value="{{$ctpx->so_luong_yeu_cau}}" class="form-control" name="so_luong_yeu_cau[]">
                                                    </td>
                                                    <td>
                                                        <input  type="number" value="{{$ctpx->so_luong_thuc_xuat}}" class="form-control so_luong" name="so_luong_thuc_xuat[]">
                                                    </td>
                                                    <td>
                                                        <input  type="text" value="{{$ctpx->gia_xuat}}" class="form-control gia_xuat" name="gia_xuat[]">
                                                    </td>
                                                    <td>
                                                        <input  type="text" value="{{$ctpx->thanh_tien}}" class="form-control thanh_tien" name="thanh_tien[]">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="submit" value="Lưu" class="btn btn-primary form-control">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection


@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function (){
            var i = 1;
            $('#add').click(function (){
                i++;
                $('#DynamicTable').append('<tr id="row'+i+'"><td><select class="form-control" name="san_pham[]">@foreach($products as $product)<option value="{{$product->id}}">{{$product->code}}</option>@endforeach</select> </td> <td> <input type="number" class="form-control" name="so_luong_yeu_cau[]"> </td> <td> <input type="number" class="form-control so_luong" name="so_luong_thuc_xuat[]"> </td> <td> <input type="number" class="form-control gia_xuat" name="gia_xuat[]"> </td> <td> <input readonly type="number" class="form-control thanh_tien" name="thanh_tien[]"> </td> <td> <button type="button" id="'+i+'" class="btn btn-danger remove_row"><i class="fa fa-minus"></i></button> </td> </tr>')
            });

            $(document).on('click','.remove_row',function (){
                var row_id = $(this).attr("id");
                $('#row'+row_id+'').remove();
            })
        })
    </script>
    <script>
        $(document).ready(function (){
            $("table").on("change", "input", function() {
                var row = $(this).closest("tr");
                var qty = parseFloat(row.find(".so_luong").val());
                var price = parseFloat(row.find(".gia_xuat").val());
                var total = qty * price;
                row.find(".thanh_tien").val(isNaN(total) ? "" : total);
            });
        })
    </script>

@endsection
