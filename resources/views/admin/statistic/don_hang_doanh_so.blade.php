@extends('admin.admin_layout')
@section('admin_content')
    <h1 class="text-center">TỔNG QUAN DOANH SỐ</h1>
    <form autocomplete="off">
        @csrf
        <div class="row">


            <div class="col-md-2">
                <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
                <p><input type="button" id="btn-dashboard-filter" class="btn btn-primary" value="Lọc kết quả"></p>
            </div>
            <div class="col-md-2">
                <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
            </div>

            <div class="col-md-2">
                <p>
                    Lọc theo:
                    <select class="dashboard-filter form-control">
                        <option>--Chọn--</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng trước</option>
                        <option value="thangnay">Tháng này</option>
                        <option value="1nam">1 Năm</option>
                    </select>
                </p>
            </div>

            <div class="col-md-12">
                <div id="stat_order_chart" style="height: 200px"></div>
            </div>
        </div>
    </form>

    {{--    <div class="row">--}}
    {{--        <p class="title_thongke">Thống kê truy cập</p>--}}
    {{--        <table class="table table-bordered">--}}
    {{--            <thead>--}}
    {{--                <tr>--}}
    {{--                    <th scope="col">Đang online</th>--}}
    {{--                    <th scope="col">Tổng tháng trước</th>--}}
    {{--                    <th scope="col">Tổng tháng này</th>--}}
    {{--                    <th scope="col">Trong năm nay</th>--}}
    {{--                    <th scope="col">Tổng truy cập</th>--}}

    {{--                </tr>--}}
    {{--            </thead>--}}
    {{--            <tbody>--}}
    {{--                <tr>--}}
    {{--                    <td>{{$visitor_count}}</td>--}}
    {{--                    <td>{{$visitor_last_month_count}}</td>--}}
    {{--                    <td>{{$visitor_this_month_count}}</td>--}}
    {{--                    <td>{{$visitor_year_count}}</td>--}}
    {{--                    <td>{{$visitor_total}}</td>--}}
    {{--                </tr>--}}
    {{--            </tbody>--}}
    {{--        </table>--}}
    {{--    </div>--}}
@endsection

@section('pagescript')
    <script type="text/javascript">
        $(function (){
            $('#datepicker').datepicker({
                prevText:'Tháng trước',
                nextText:'Tháng sau',
                dateFormat:'yy-mm-dd',
                dayNamesMin: ['Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhật'],
                duration: 'slow'
            });

            $('#datepicker2').datepicker({
                prevText:'Tháng trước',
                nextText:'Tháng sau',
                dateFormat:'yy-mm-dd',
                dayNamesMin: ['Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhật'],
                duration: 'slow'
            });
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function (){
            chart30daysorder()

            var chart = new Morris.Area({
                // ID of the element in which to draw the chart.
                element: 'stat_order_chart',
                lineColors: ['#819C79','#FC8710','#FF6541','#A4ADD3','#766B56'],
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                fillOpacity: 0.6,
                hideHover:'auto',
                parseTime:false,

                // The name of the data record attribute that contains x-values.


                xkey: 'period',
                xLabelAngle: 45,

                // A list of names of data record attributes that contain y-values.
                ykeys: ['order','sales','quantity'],
                behaveLikeLine: true,
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Đơn hàng bán','Doanh số','Số lượng bán']
            });

            function chart30daysorder(){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{url('/days-order')}}",
                    method:"POST",
                    dataType:"JSON",
                    data:{_token:_token},
                    success:function (data){
                        chart.setData(data)
                    }
                })
            }

            $('.dashboard-filter').change(function (){
                var dashboard_value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{url('/dashboard-filter')}}",
                    method:"POST",
                    dataType:"JSON",
                    data:{dashboard_value:dashboard_value,_token:_token},
                    success:function (data){
                        chart.setData(data)
                    }
                })
            })

            $('#btn-dashboard-filter').click(function (){
                var _token = $('input[name="_token"]').val();
                var from_date = $('#datepicker').val();
                var to_date = $('#datepicker2').val();
                $.ajax({
                    url:"{{url('/filter-by-date')}}",
                    method:"POST",
                    dataType:"JSON",
                    data:{from_date:from_date,to_date:to_date,_token:_token},
                    success:function (data){
                        chart.setData(data)
                    }
                })
            })
        })
    </script>
@endsection
