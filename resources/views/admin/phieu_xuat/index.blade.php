@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('phieu-xuat') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Phiếu xuất
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-4">
                    <a href="{{route('add-phieu-xuat')}}"><span class="btn btn-primary fa fa-plus">Thêm Phiếu xuất</span></a>
                </div>
{{--                <div class="col-sm-3">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" class="input-sm form-control" placeholder="Search">--}}
{{--                        <span class="input-group-btn">--}}
{{--            <button class="btn btn-sm btn-default" type="button">Go!</button>--}}
{{--          </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên Phiếu xuất</th>
                        <th>Đơn hàng</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Người lập</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($phieu_xuats as $key => $phieu_xuat)
                        <tr>
                            <td>{{$phieu_xuat->name}}</td>
                            <td>{{$phieu_xuat->order_id}}</td>
                            <td>{{$phieu_xuat->content}}</td>
                            <td>{{$phieu_xuat->trang_thai}}</td>
                            <td>{{number_format($phieu_xuat->tong_tien,2,",",".")}} đ</td>
                            @php
                                $nguoi_lap = \App\Models\Admin::find($phieu_xuat->nguoi_lap_id);
                            @endphp
                            @if($nguoi_lap)
                                <td>{{$nguoi_lap->name}}</td>
                            @else
                                <td>{{''}}</td>
                            @endif
                            <td>{{$phieu_xuat->updated_at}}</td>
                            <td>
                                <a href="{{route('edit-phieu-xuat',['id'=>$phieu_xuat->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-phieu-xuat',['id'=>$phieu_xuat->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-phieu-xuat',['id'=>$phieu_xuat->id])}}" class="active" ui-toggle-class="">
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
