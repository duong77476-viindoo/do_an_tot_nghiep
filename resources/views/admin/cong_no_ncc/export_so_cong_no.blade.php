<table>
    <thead>
    <tr>
        <td>BÁO CÁO TỔNG HỢP CÔNG NỢ PHẢI TRẢ</td>
    </tr>
    <tr>
        <td>Năm: {{$cong_no_nccs[0]->year}}</td>
    </tr>
    <tr>
        <td>Tháng : {{$cong_no_nccs[0]->month}}</td>
    </tr>
    <tr>
        <th>STT</th>
        <th>Nhà cung cấp</th>
        <th>Công nợ đầu tháng</th>
        <th>Công nợ cuối tháng</th>
        <th>Công nợ đã thanh toán</th>
        <th>Công nợ còn</th>
    </tr>
    </thead>
    <tbody>
    @php
        $dem = 1;
    @endphp
    @foreach($cong_no_nccs as $cong_no_ncc)
        <tr>
            <td>{{ $dem++ }}</td>
            <td>{{ $cong_no_ncc->nha_cung_cap->name }}</td>
            <td>{{ $cong_no_ncc->cong_no_dau_thang }}</td>
            <td>{{ $cong_no_ncc->cong_no_cuoi_thang }}</td>
            <td>{{ $cong_no_ncc->cong_no_da_thanh_toan }}</td>
            <td>{{ $cong_no_ncc->cong_no_con}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
