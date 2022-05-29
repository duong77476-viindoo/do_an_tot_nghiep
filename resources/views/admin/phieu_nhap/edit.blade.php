@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit-phieu-nhap',$phieu_nhap) }}
    @if($phieu_nhap->trang_thai=="Chưa xác nhận")
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
                                <form role="form" action="{{route('update-phieu-nhap',['id'=>$phieu_nhap->id])}}" method="post" >
                                    {{csrf_field()}}
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
                                                    <select name="nha_cung_cap_id" id="nha_cung_cap_id" class="form-control">
                                                        {{--                                                    <option value="">---Chọn---</option>--}}
                                                        @foreach($nha_cung_caps as $key=>$nha_cung_cap)
                                                            <option {{$phieu_nhap->nha_cung_cap_id==$nha_cung_cap->id ? 'selected' : ''}} value="{{$nha_cung_cap->id}}">{{$nha_cung_cap->name}}</option>
                                                        @endforeach
                                                    </select>
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
                                                    <input class="form-control" type="text" value="{{$phieu_nhap->name}}" name="name" placeholder="Nhập tên phiếu">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <label>Nội dung:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <input class="form-control" id="noi_dung" value="{{$phieu_nhap->content}}" type="text" name="noi_dung" placeholder="Nhập nội dung">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                            <div class="form-group">
                                                <label>Trạng thái:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                    </div>
                                                    <select class="form-control" name="trang_thai">
                                                        @if($phieu_nhap->trang_thai=="Chưa xác nhận")
                                                            <option value="Chưa xác nhận" selected>Chưa xác nhận</option>
                                                            <option value="Xác nhận">Xác nhận</option>
                                                        @else
                                                            <option value="Chưa xác nhận">Chưa xác nhận</option>
                                                            <option value="Xác nhận" selected>Xác nhận</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
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
                                                            <input value="{{$product->id}}" type="hidden" name="san_pham[]">
                                                            <input value="{{$product->name}}" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="number" value="{{$ctpn->so_luong_yeu_cau}}" class="form-control" name="so_luong_yeu_cau[]">
                                                        </td>
                                                        <td>
                                                            <input type="number" value="{{$ctpn->so_luong_thuc_nhap}}" class="form-control so_luong" name="so_luong_thuc_nhap[]">
                                                        </td>
                                                        <td>
                                                            <input type="text" value="{{number_format($ctpn->gia_nhap,0,",",".")}} đ" class="form-control gia_nhap" name="gia_nhap[]">
                                                        </td>
                                                        <td>
                                                            <input type="text" value="{{number_format($ctpn->thanh_tien,0,",",".")}} đ" class="form-control thanh_tien" name="thanh_tien[]">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
{{--                                            <a href="{{route('print-phieu-nhap',['id'=>$phieu_nhap->id])}}" target="_blank" class="btn btn-primary btn-lg">Xuất phiếu nhập</a>--}}
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-primary form-control" value="Xác nhận và lưu">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>
    @else
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
                                            <a href="{{route('print-phieu-nhap',['id'=>$phieu_nhap->id])}}" target="_blank" class="btn btn-primary btn-lg">Xuất phiếu nhập</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    @endif
@endsection

@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function (){
            var i = 1;
            $('#add').click(function (){
                i++;
                $('#DynamicTable').append('<tr id="row'+i+'"><td><select class="form-control" name="san_pham[]">@foreach($products as $product)<option value="{{$product->id}}">{{$product->code}}</option>@endforeach</select> </td> <td> <input type="number" class="form-control" name="so_luong_yeu_cau[]"> </td> <td> <input type="number" class="form-control so_luong" name="so_luong_thuc_nhap[]"> </td> <td> <input type="text" class="form-control money'+i+' gia_nhap"  name="gia_nhap[]"> </td> <td> <input readonly type="text" class="form-control thanh_tien" name="thanh_tien[]"> </td> <td> <button type="button" id="'+i+'" class="btn btn-danger remove_row"><i class="fa fa-minus"></i></button> </td> </tr>')
                new AutoNumeric('.money'+i+'', {
                    currencySymbol :'đ',
                    decimalPlaces: 2,
                    digitGroupSeparator : ',',
                    decimalCharacter : '.',
                    currencySymbolPlacement : 's'
                });
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
                var price_no_currency = row.find(".gia_nhap").val().replace("đ","");
                for(var i=0;i<price_no_currency.length;i++){
                    if(price_no_currency[i].includes(",")){
                        price_no_currency = price_no_currency.replace(price_no_currency[i],"");
                    }
                }
                var price_parsed = parseFloat(price_no_currency);
                var total = qty * price_parsed;
                row.find(".thanh_tien").val(isNaN(total) ? "" : total+'đ');
            });
        })
    </script>

@endsection


