@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Công nợ nhà cung cấp
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Nhà cung cấp</th>
                        <th>Năm</th>
                        <th>Tháng</th>
                        <th>Công nợ đầu tháng</th>
                        <th>Công nợ cuối tháng</th>
                        <th>Công nợ đã thanh toán</th>
                        <th>Công nợ còn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cong_no_nccs as $key => $cong_no_ncc)
                        <tr>
                            <td>{{$cong_no_ncc->nha_cung_cap->name}}</td>
                            <td>{{$cong_no_ncc->year}}</td>
                            <td>{{$cong_no_ncc->month}}</td>
                            <td>{{number_format($cong_no_ncc->cong_no_dau_thang,2,'.',',')}} đ</td>
                            <td>{{number_format($cong_no_ncc->cong_no_cuoi_thang,2,'.',',')}} đ</td>
                            <td>{{number_format($cong_no_ncc->cong_no_da_thanh_toan,2,'.',',')}} đ</td>
                            <td>{{number_format($cong_no_ncc->cong_no_con,2,'.',',')}} đ</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <div id="cong_no_chart" style="height: 200px"></div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function (){
            cong_no_chart();

            var chart = new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'cong_no_chart',
                lineColors: ['#819C79','#FC8710','#FF6541','#A4ADD3'],
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                fillOpacity: 0.6,
                hideHover:'auto',
                parseTime:false,

                // The name of the data record attribute that contains x-values.


                xkey: 'nha_cung_cap',
                xLabelAngle: 45,

                // A list of names of data record attributes that contain y-values.
                ykeys: ['cong_no_dau_thang','cong_no_cuoi_thang','cong_no_da_thanh_toan','cong_no_con'],
                behaveLikeLine: true,
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Công nợ đầu tháng','công nợ cuối tháng','Công nợ đã thanh toán','Công nợ còn']
            });

            function cong_no_chart(){$.ajax({
                    url:"{{url('/cong-no-chart')}}",
                    method:"POST",
                    dataType:"JSON",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (data){
                        chart.setData(data)
                    }
                })
            }
        })
    </script>
@endsection

