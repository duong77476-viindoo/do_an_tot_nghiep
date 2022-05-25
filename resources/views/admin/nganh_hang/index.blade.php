@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('nganh_hang') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục ngành hàng
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
                    <a href="{{route('add-nganh-hang')}}"><span class="btn btn-primary fa fa-plus">Thêm ngành hàng</span></a>
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
                        <th>Tên ngành hàng</th>
                        <th>Code ngành hàng</th>
                        <th>Đặc tính</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nganh_hangs as $key => $nganh_hang)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="nganh_hang[]"><i></i></label></td>
                            <td>{{$nganh_hang->name}}</td>
                            <td>{{$nganh_hang->code}}</td>
                            <td><a href="{{route('add-dac-tinh',['id'=>$nganh_hang->id])}}">Thêm đặc tính</a></td>
                            <td>{{$nganh_hang->updated_at}}</td>
                            <td>
                                <a href="{{route('edit-nganh-hang',['id'=>$nganh_hang->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-nganh-hang',['id'=>$nganh_hang->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-nganh-hang',['id'=>$nganh_hang->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-eye text-success text-active"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
