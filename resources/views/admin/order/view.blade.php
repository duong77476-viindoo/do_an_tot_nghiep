@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng mua
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$order->customer->name}}</td>
                            <td>{{$order->customer->email}}</td>
                            <td>{{$order->customer->phone}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên người vận chuyền</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Ghi chú</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$order->shipping->name}}</td>
                            <td>{{$order->shipping->address}}</td>
                            <td>{{$order->shipping->phone}}</td>
                            <td>{{$order->shipping->ghi_chu}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin đơn hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng tồn</th>
                        <th>Đơn giá</th>
                        <th>Số lượng đặt</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach($order_detail as $key => $item)
                        <tr class="color_qty_{{$item->product_id}}">
                            <td>{{$item->product_id}}</td>
                            <td>{{$item->product->code}}</td>
                            <td>{{$item->product->so_luong}}</td>
                            <input type="hidden" name="so_luong_ton" class="so_luong_ton_{{$item->product_id}}" value="{{$item->product->so_luong}}">
                            <input type="hidden" name="so_luong_dat" class="so_luong_dat_{{$item->product_id}}" value="{{$item->so_luong}}">
                            <input type="hidden" name="product_id" class="product_id" value="{{$item->product_id}}">
                            <input type="hidden" value="{{$item->so_luong}}" name="product_qty">
                            <td>{{number_format($item->product_price,0,',','.')}} VND</td>
                            <td>{{$item->so_luong}}</td>
                            @php
                                $subtotal += $item->product_price * $item->so_luong;
                            @endphp
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="alert alert-dismissable">
        <form>
            @csrf
            <label>
                Trạng thái:
                <select name="order_status" class="form-control update_order_status">
                    @if($order->trang_thai == "Đang xử lý")
                        <option id="{{$order->id}}" value="Đang xử lý" {{$order->trang_thai=="Đang xử lý" ? 'selected' : ''}}>Đang xử lý</option>
                        <option id="{{$order->id}}" value="Đang giao hàng" {{$order->trang_thai=="Đang giao hàng" ? 'selected' : ''}}>Đang giao hàng</option>
                        <option id="{{$order->id}}" value="Đã giao hàng" {{$order->trang_thai=="Đã giao hàng" ? 'selected' : ''}}>Đã giao hàng</option>
                        <option id="{{$order->id}}" value="Chờ xác nhận hủy" {{$order->trang_thai=="Chờ xác nhận hủy" ? 'selected' : ''}}>Chờ xác nhận hủy</option>
                        <option onchange="return confirm('Bạn có chắc muốn hủy đơn hàng?')" id="{{$order->id}}" value="Đã hủy" {{$order->trang_thai=="Đã hủy" ? 'selected' : ''}}>Đã hủy</option>
                    @elseif($order->trang_thai == "Đang giao hàng")
                        <option id="{{$order->id}}" value="Đang giao hàng" {{$order->trang_thai=="Đang giao hàng" ? 'selected' : ''}}>Đang giao hàng</option>
                        <option id="{{$order->id}}" value="Đã giao hàng" {{$order->trang_thai=="Đã giao hàng" ? 'selected' : ''}}>Đã giao hàng</option>
                    @elseif($order->trang_thai == "Chờ xác nhận hủy")
                        <option id="{{$order->id}}" value="Chờ xác nhận hủy" {{$order->trang_thai=="Chờ xác nhận hủy" ? 'selected' : ''}}>Chờ xác nhận hủy</option>
                        <option onchange="return confirm('Bạn có chắc muốn hủy đơn hàng?')" id="{{$order->id}}" value="Đã hủy" {{$order->trang_thai=="Đã hủy" ? 'selected' : ''}}>Đã hủy</option>
                    @elseif($order->trang_thai == "Đã hủy")
                        <option onchange="return confirm('Bạn có chắc muốn hủy đơn hàng?')" id="{{$order->id}}" value="Đã hủy" {{$order->trang_thai=="Đã hủy" ? 'selected' : ''}}>Đã hủy</option>
                    @elseif($order->trang_thai == "Đã giao hàng")
                        <option id="{{$order->id}}" value="Đã giao hàng" {{$order->trang_thai=="Đã giao hàng" ? 'selected' : ''}}>Đã giao hàng</option>
                    @elseif($order->trang_thai == "Đang chờ xử lý")
                        <option id="{{$order->id}}" value="Đang chờ xử lý" {{$order->trang_thai=="Đang chờ xử lý" ? 'selected' : ''}}>Đang chờ xử lý</option>
                        <option id="{{$order->id}}" value="Đang xử lý" {{$order->trang_thai=="Đang xử lý" ? 'selected' : ''}}>Đang xử lý</option>
                        <option id="{{$order->id}}" value="Chờ xác nhận hủy" {{$order->trang_thai=="Chờ xác nhận hủy" ? 'selected' : ''}}>Chờ xác nhận hủy</option>
                        <option onchange="return confirm('Bạn có chắc muốn hủy đơn hàng?')" id="{{$order->id}}" value="Đã hủy" {{$order->trang_thai=="Đã hủy" ? 'selected' : ''}}>Đã hủy</option>
                    @endif
                </select>
            </label>
        </form>
    </div>
    <div class="alert alert-success" role="alert">
        Thành tiền : {{number_format($subtotal,0,',','.')}} VND
        <br>
        Phí vận chuyển : {{number_format($order->fee_ship,0,'','.')}} VND
        <br>
        Được giảm giá : {{number_format($order->coupon,2,',','.')}} VND
        <br>
        VAT : 0 VND
        <br>
        Tổng tiền : {{number_format($order->tong_tien,2,',','.')}} VND
    </div>
    <a href="{{url('/print-order/'.$order->id)}}" target="_blank" class="btn btn-primary btn-lg">Xuất hóa đơn</a>


@endsection
