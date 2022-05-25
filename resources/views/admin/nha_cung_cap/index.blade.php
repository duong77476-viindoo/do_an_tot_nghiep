@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('provider') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục nhà cung cấp
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
                <div class="col-sm-4">
                    <a href="{{route('add-nha-cung-cap')}}"><span class="btn btn-primary fa fa-plus">Thêm nhà cung cấp</span></a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Tên nhà cung cấp</th>
                        <th>Điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Số tiền còn nợ</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nha_cung_caps as $key => $nha_cung_cap)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="nha_cung_cap[]"><i></i></label></td>
                            <td>{{$nha_cung_cap->name}}</td>
                            <td>{{$nha_cung_cap->phone}}</td>
                            <td>{{$nha_cung_cap->address}}</td>
                            <td>{{$nha_cung_cap->so_tien_no}}</td>
                            <td>{{$nha_cung_cap->updated_at}}</td>
                            <td>
                                <a href="{{route('edit-nha-cung-cap',['id'=>$nha_cung_cap->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-nha-cung-cap',['id'=>$nha_cung_cap->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-nha-cung-cap',['id'=>$nha_cung_cap->id])}}" class="active" ui-toggle-class="">
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
                            {{ $nha_cung_caps->links() }}
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
