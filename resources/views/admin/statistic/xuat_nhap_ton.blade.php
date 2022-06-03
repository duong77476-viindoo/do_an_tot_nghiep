@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('statistic-xuat-nhap-ton') }}
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
        </div>
        <div class="col-md-12">
            <div id="stat_xuat_nhap_ton" style="height: 200px"></div>
        </div>
    </div>
@endsection

@section('pagescript')

    <script type="text/javascript">
        $(document).ready(function (){
            xuat_nhap_ton_chart();


            var chart = new Morris.Area({
                // ID of the element in which to draw the chart.
                element: 'stat_xuat_nhap_ton',
                lineColors: ['#819C79','#FC8710','#FF6541','#A4ADD3'],
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                fillOpacity: 0.6,
                hideHover:'auto',
                parseTime:false,

                // The name of the data record attribute that contains x-values.


                xkey: 'month_year',
                xLabelAngle: 45,

                // A list of names of data record attributes that contain y-values.
                ykeys: ['tong_nhap','tong_xuat','tong_ton'],
                behaveLikeLine: true,
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Tổng nhập','Tổng xuất','Tổng tồn']
            });

            function xuat_nhap_ton_chart(){
                $.ajax({
                    url:"{{url('/xuat-nhap-ton-chart')}}",
                    method:"POST",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType:"JSON",
                    success:function (data){
                        chart.setData(data)
                    }
                })
            }
        })
    </script>
@endsection


