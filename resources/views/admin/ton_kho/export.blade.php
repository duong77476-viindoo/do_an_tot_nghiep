<table>
    <thead>
    <tr>
        <td>BÁO CÁO TỒN KHO </td>
    </tr>
    <tr>
       <td>Năm: {{$ton_khos[0]->year}}</td>
    </tr>
    <tr>
        <td>Tháng : {{$ton_khos[0]->month}}</td>
    </tr>
    <tr>
        <th>STT</th>
        <th>Sản phẩm</th>
        <th>Tồn đầu tháng</th>
        <th>Nhập trong tháng</th>
        <th>Xuất trong tháng</th>
        <th>Tồn</th>
    </tr>
    </thead>
    <tbody>
    @php
        $dem = 1;
    @endphp
    @foreach($ton_khos as $ton_kho)
        <tr>
            <th>{{ $dem++ }}</th>
            <td>{{ $ton_kho->product->name }}</td>
            <td>{{ $ton_kho->ton_dau_thang }}</td>
            <td>{{ $ton_kho->nhap_trong_thang }}</td>
            <td>{{ $ton_kho->xuat_trong_thang }}</td>
            <td>{{ $ton_kho->ton}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
