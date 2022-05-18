@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thống kê xuất nhập tồn
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Năm</th>
                        <th>Tháng</th>
                        <th>Tồn đầu tháng</th>
                        <th>Nhập trong tháng</th>
                        <th>Xuất trong tháng</th>
                        <th>Tồn</th>
                        <th>Tổng tiền nhập</th>
                        <th>Tồng tiền bán</th>
                        <th>Chênh lệch</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ton_khos as $key => $ton_kho)
                        @php
                            $tong_tien_nhap = 0;
                            $chi_tiet_phieu_nhaps = \App\Models\ChiTietPhieuNhap::where("product_id",$ton_kho->product_id)
                            ->whereMonth("updated_at",$ton_kho->month)->get();
                            foreach ($chi_tiet_phieu_nhaps as $chi_tiet_phieu_nhap){
                                $tong_tien_nhap += $chi_tiet_phieu_nhap->thanh_tien;
                            }
                            //Tính tổng tiền bán
                            $product = \App\Models\Product::find($ton_kho->product_id);
                            $tong_tien_ban = $product->gia_ban * $ton_kho->xuat_trong_thang;

                            //Chênh lệch
                            $chenh_lech = $tong_tien_ban - $tong_tien_nhap;
                        @endphp
                        <tr>
                            <td>{{$ton_kho->product->name}}</td>
                            <td>{{$ton_kho->year}}</td>
                            <td>{{$ton_kho->month}}</td>
                            <td>{{$ton_kho->ton_dau_thang}}</td>
                            <td>{{$ton_kho->nhap_trong_thang}}</td>
                            <td>{{$ton_kho->xuat_trong_thang}}</td>
                            <td>{{$ton_kho->ton}}</td>
                            <td>{{number_format($tong_tien_nhap,2,'.',',')}} đ</td>
                            <td>{{number_format($tong_tien_ban,2,'.',',')}} đ</td>
                            <td>{{number_format($chenh_lech,2,'.',',')}} đ</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    {{--                    <div class="col-sm-5 text-center">--}}
                    {{--                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>--}}
                    {{--                    </div>--}}
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{--                            {{ $phieu_xuats->links() }}--}}
                            {{--                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>--}}
                            {{--                            <li><a href="">1</a></li>--}}
                            {{--                            <li><a href="">2</a></li>--}}
                            {{--                            <li><a href="">3</a></li>--}}
                            {{--                            <li><a href="">4</a></li>--}}
                            {{--                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>--}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection

