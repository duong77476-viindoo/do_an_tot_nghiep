@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('cong-no-ncc') }}
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
            <div style="display: block">
{{--                <div class="col-sm-3 m-b-xs">--}}
{{--                    <select class="input-sm form-control w-sm inline v-middle">--}}
{{--                        <option value="0">Bulk action</option>--}}
{{--                        <option value="1">Delete selected</option>--}}
{{--                        <option value="2">Bulk edit</option>--}}
{{--                        <option value="3">Export</option>--}}
{{--                    </select>--}}
{{--                    <button class="btn btn-sm btn-default">Apply</button>--}}
{{--                </div>--}}
                <form action="{{route('export-so-cong-no')}}" method="post">
                    @csrf
                <div style="display: inline-block">
                    <select class="form-control" name="year">
                        <option>2019</option>
                        <option>2020</option>
                        <option>2021</option>
                        <option>2022</option>
                        <option>2023</option>
                        <option>2024</option>
                        <option>2025</option>
                        <option>2026</option>
                    </select>
                </div>
                <div style="display: inline-block">
                    <select class="form-control" name="month">
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                    </select>
                </div>
                    <div style="display: inline-block">
                        <input type="submit" class="btn btn-primary" value="Xuất báo cáo tổng hợp công nợ">
                    </div>
                </form>

                <div style="display: inline-block">
                        <button type="button" class="btn btn-primary chot_cong_no">Chốt số liệu</button>
                </div>


            </div>


            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Nhà cung cấp</th>
                        <th>Năm</th>
                        <th>Tháng</th>
                        <th>Công nợ đầu tháng</th>
                        <th>Công nợ phát sinh</th>
                        <th>Công nợ đã thanh toán</th>
                        <th>Công nợ còn</th>
                        <th>Trạng thái</th>
{{--                        <th>Xuất</th>--}}
{{--                        <th>Hành động</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cong_no_nccs as $key => $cong_no_ncc)
                        <tr class="{{$cong_no_ncc->trang_thai=="Hoàn thành" ? 'table-success' : 'table-active'}}">
                            <td>{{$cong_no_ncc->nha_cung_cap->name}}</td>
                            <td>{{$cong_no_ncc->year}}</td>
                            @php
                                $date = date("Y-m-d");
                                //Lấy năm, tháng trước
                                $pre_month = date("m", strtotime ( '-1 month' , strtotime ( $date ) ));
                                $pre_year = date("Y", strtotime ( '-1 month' , strtotime ( $date ) ));
                                //Lấy năm tháng hiện tại
                                $month = date("m");
                                $year = date('Y');
                            @endphp
                            @if($cong_no_ncc->trang_thai=="Chưa hoàn thành" && $cong_no_ncc->month==$pre_month && $cong_no_ncc->year==$pre_year)
                                <td class="pre_cong_no_month">{{$cong_no_ncc->month}}</td>
                            @elseif($cong_no_ncc->trang_thai=="Chưa hoàn thành" && $cong_no_ncc->month==$month && $cong_no_ncc->year==$year)
                                <td class="cong_no_month">{{$cong_no_ncc->month}}</td>
                            @else
                                <td>{{$cong_no_ncc->month}}</td>
                            @endif
                            <td>{{number_format($cong_no_ncc->cong_no_dau_thang,2,'.',',')}} đ</td>
                            <td>{{number_format($cong_no_ncc->cong_no_cuoi_thang,2,'.',',')}} đ</td>
                            <td>{{number_format($cong_no_ncc->cong_no_da_thanh_toan,2,'.',',')}} đ</td>
                            <td>{{number_format($cong_no_ncc->cong_no_con,2,'.',',')}} đ</td>
                            @if($cong_no_ncc->trang_thai=="Hoàn thành")
                                <td>Đã chốt</td>
                            @else
                                <td>Chưa chốt</td>
                            @endif
{{--                            <td>--}}
{{--                                <a href="{{route('export-xac-nhan-cong-no',['id'=>$cong_no_ncc->id])}}" class="active" ui-toggle-class="">--}}
{{--                                    <i class="fa fa-file-export text-success text-active"></i> Xuất biên bản xác nhận--}}
{{--                                </a>--}}
{{--                                <br>--}}
{{--                                <a href="{{route('export-doi-chieu-cong-no',['id'=>$cong_no_ncc->id])}}" class="active" ui-toggle-class="">--}}
{{--                                    <i class="fa fa-file-contract text-success text-active"></i> Xuất biên bản đối chiếu--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <a href="{{route('edit-cong-no-ncc',['id'=>$cong_no_ncc->id])}}"--}}
{{--                                   class="active" ui-toggle-class=""><i class="fa fa-pen text-success text"></i></a>--}}
{{--                                <a href="{{route('delete-cong-no-ncc',['id'=>$cong_no_ncc->id])}}"--}}
{{--                                   onclick="return confirm('Bạn có chắc muốn xóa?')"--}}
{{--                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>--}}
{{--                            </td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function (){
            $('.chot_cong_no').click(function(){
                var currentdate = new Date();
                var currentmonth = String(currentdate.getMonth() + 1).padStart(2, '0');
                var cong_no_month = $('.cong_no_month').text()[0] + $('.cong_no_month').text()[1];
                var pre_cong_no_month = $('.pre_cong_no_month').text()[0] + $('.pre_cong_no_month').text()[1];
                if(pre_cong_no_month){
                    swal({
                            title: "Chốt công nợ tháng này",
                            text: "Vui lòng check kỹ lại thông tin",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Chốt",
                            cancelButtonText: "Hủy bỏ!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: '{{url('/cong-no-ncc/chot-cong-no')}}',
                                    method: 'POST',
                                    headers:{
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success:function()
                                    {
                                        swal({
                                                title: "Chốt số liệu công nợ thành công",
                                                text: "",
                                                confirmButtonClass: "btn-success",
                                                confirmButtonText: "Tiếp tục",
                                                closeOnConfirm: false
                                            },
                                            function() {
                                                window.location.href = "{{url('/cong-no-ncc/all')}}";
                                            });
                                    }
                                });
                            } else {
                                swal("Đã hủy", "Tiếp tục theo dõi", "error");
                            }
                        });
                }
                else if(currentmonth==cong_no_month || cong_no_month==null || cong_no_month===""){
                    swal({
                            title: "Không thể thực hiện hành động này, do chưa đến thời hạn",
                            text: "Bạn vẫn còn số liệu liên quan cần xử lý",
                            type: "warning",
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Tiếp tục",
                            closeOnConfirm: true,
                            closeOnCancel: false
                    });
                }
                else{
                    swal({
                            title: "Chốt công nợ tháng này",
                            text: "Vui lòng check kỹ lại thông tin",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Xác nhận",
                            cancelButtonText: "Hủy bỏ!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: '{{url('/cong-no-ncc/chot-cong-no')}}',
                                    method: 'POST',
                                    headers:{
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success:function()
                                    {
                                        swal({
                                                title: "Chốt công nợ thành công",
                                                text: "",
                                                confirmButtonClass: "btn-success",
                                                confirmButtonText: "Tiếp tục",
                                                closeOnConfirm: false
                                            },
                                            function() {
                                                window.location.href = "{{url('/cong-no-ncc/all')}}";
                                            });
                                    }
                                });
                            } else {
                                swal("Đã hủy chốt công nợ", "Tiếp tục theo dõi công nợ", "error");
                            }
                        });
                }
            });
        })
    </script>
@endsection
