<table>
    <thead>
    <tr>
        <td>HÓA ĐƠN</td>
    </tr>
    <tr>
        <td>Khách hàng {{$order->customer->name}}</td>
    </tr>
    <tr>
        <td>Ngày đặt hàng {{$order->oder_date}}</td>
    </tr>
    <tr>
        <th>STT</th>
        <th>Mã</th>
        <th>Tên</th>
        <th>Đơn giá</th>
        <th>Số lượng</th>
    </tr>
    </thead>
    <tbody>
    @php
        $dem = 1;
    @endphp
    @foreach($order_detail as $item)
        <tr>
            <td>{{ $dem++ }}</td>
            <td>{{ $item->product_id }}</td>
            <td>{{ $item->product->code }}</td>
            <td>{{number_format($item->product_price,0,',','.')}} VND</td>
            <td>{{ $item->so_luong }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
