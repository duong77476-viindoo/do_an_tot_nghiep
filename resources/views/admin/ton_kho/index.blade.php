@extends('admin.admin_layout')
@section('admin_content')
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
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-2">
                    <a href="{{route('add-ton-kho')}}"><span class="btn btn-primary"><i class="fa fa-plus"></i>Thêm</span></a>
                </div>
                <div class="col-sm-2">
                    @php
                         $month = date("m");
                         $year = date('Y');
                    @endphp
                    @if($ton_khos[0]->year!=$year || $ton_khos[0]->month!=$month)
                        <button type="button" class="btn btn-primary chot_ton_kho">Chốt số lượng tồn</button>
                    @endif
                </div>
                <div class="col-sm-2">
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
                            <td>{{$ton_kho->month}}</td>
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
            });
        })
    </script>
@endsection
