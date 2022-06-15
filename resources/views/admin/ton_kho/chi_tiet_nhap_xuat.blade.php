@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Chi tiết nhập xuất {{$ton_kho->product->name}} tháng {{$ton_kho->month}} năm {{$ton_kho->year}}
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
                        <th>Mã định danh</th>
                        <th>Trạng thái</th>
                        <th>Phiếu nhập</th>
                        <th>Phiếu xuất</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product->product_identities as $key => $product)
                        <tr class="{{$product->trang_thai=="Đã xuất" ? 'table-success' : 'table-active'}}">
                            <td>{{$product->code}}</td>
                            <td>{{$product->trang_thai}}</td>
                            <td>{{$product->phieu_nhap_id}}</td>
                            <td>{{$product->phieu_xuat_id}}</td>
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
            $('.chot_ton_kho').click(function(){
                var currentdate = new Date();
                var currentmonth = String(currentdate.getMonth() + 1).padStart(2, '0');
                var ton_kho_month = $('.ton_kho_month').text()[0] + $('.ton_kho_month').text()[1];
                var pre_ton_kho_month = $('.pre_ton_kho_month').text()[0] + $('.pre_ton_kho_month').text()[1];
                if(pre_ton_kho_month){
                    swal({
                            title: "Chốt số lượng tồn tháng này",
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
                                    url: '{{url('/ton-kho/chot-ton-kho')}}',
                                    method: 'POST',
                                    headers:{
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success:function()
                                    {
                                        swal({
                                                title: "Chốt số liệu tồn kho thành công",
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
                                swal("Đã hủy", "Tiếp tục theo dõi", "error");
                            }
                        });
                }

                else if(currentmonth==ton_kho_month || ton_kho_month==null || ton_kho_month===""){
                    swal({
                        title: "Không thể thực hiện hành động này, do chưa đến thời hạn",
                        text: "Bạn vẫn còn số liệu liên quan cần xử lý",
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
                            confirmButtonText: "Xác nhận",
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
