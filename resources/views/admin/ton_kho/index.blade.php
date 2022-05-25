@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('ton-kho') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thống kê tồn kho theo từng sản phẩm
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div style="display: block">
                <div style="display:inline-block;">
                    <button type="button" class="btn btn-primary chot_ton_kho">Chốt số lượng tồn</button>
                </div>
                <div style="display:inline-block;">
                    <form action="{{route('ton-kho-export-csv')}}" method="POST">
                        @csrf
                        <label>
                            Năm
                            <select class="form-control" name="year">
                                <option>2019</option>
                                <option>2020</option>
                                <option>2021</option>
                                <option>2022</option>
                            </select>
                        </label>
                        <label>
                            Tháng
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
                        </label>
                        <input type="submit" value="Xuất báo cáo tồn kho" name="export_csv" class="btn btn-success">
                    </form>
                </div>
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
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ton_khos as $key => $ton_kho)
                        <tr>
                            <td>{{$ton_kho->product->name}}</td>
                            <td>{{$ton_kho->year}}</td>
                            <td class="{{$ton_kho->trang_thai=='Chưa hoàn thành' ? 'ton_kho_month' : ''}}">{{$ton_kho->month}}</td>
                            <td>{{$ton_kho->ton_dau_thang}}</td>
                            <td>{{$ton_kho->nhap_trong_thang}}</td>
                            <td>{{$ton_kho->xuat_trong_thang}}</td>
                            <td>{{$ton_kho->ton}}</td>
                            <td>{{$ton_kho->trang_thai}}</td>
                            <td>
                                <a href="{{route('edit-ton-kho',['id'=>$ton_kho->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-ton-kho',['id'=>$ton_kho->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-ton-kho',['id'=>$ton_kho->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-eye text-success text-active"></i>
                                </a>
                            </td>
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

@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function (){
            $('.chot_ton_kho').click(function(){
                var currentdate = new Date();
                var currentmonth = String(currentdate.getMonth() + 1).padStart(2, '0');
                var ton_kho_month = $('.ton_kho_month').text()[0] + $('.ton_kho_month').text()[1] ;
                alert(ton_kho_month);
                if(currentmonth==ton_kho_month || ton_kho_month==null || ton_kho_month===""){
                    swal({
                        title: "Không thể chốt số lượng tồn tháng này",
                        text: "Do chưa đến thời hạn",
                        type: "warning",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Tiếp tục",
                        closeOnConfirm: true,
                        closeOnCancel: false
                    });
                }else{
                    swal({
                            title: "Chốt số lượng tồn kho",
                            text: "Vui lòng check kỹ lại thông tin tồn kho",
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
                                    url: '{{url('/ton-kho/chot-ton-kho')}}',
                                    method: 'POST',
                                    headers:{
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success:function()
                                    {
                                        swal({
                                                title: "Chốt số lượng thành công",
                                                text: "",
                                                confirmButtonClass: "btn-success",
                                                confirmButtonText: "Tiếp tục",
                                                closeOnConfirm: false
                                            },
                                            function() {
                                                window.location.href = "{{url('/ton-kho/all')}}";
                                            });
                                    }
                                });
                            } else {
                                swal("Đã hủy chốt số lượng", "Tiếp tục theo dõi số lượng tồn", "error");
                            }
                        });
                }
            });
        })
    </script>
@endsection
