@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('user') }}

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách người dùng hệ thống
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
                    <a href="{{route('register-admin')}}"><span class="btn btn-primary fa fa-plus">Thêm người dùng</span></a>
                </div>
            </div>
            <div class="table-responsive">
{{--                Để id myTable sê lỗi không phân quyền được nên tạm thời xóa đi, xem xét cách fix--}}
                <table id="" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        @foreach($roles as $key=>$role)
                            <th>{{$role->name}}</th>
                        @endforeach
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($admins as $key => $admin)
                        <form action="{{route('assign-roles')}}" method="post">
                        @csrf
                        <tr>
                            <td>{{$admin->name}}</td>
                            <td>
                                {{$admin->email}}
                                <input type="hidden" name="email" value="{{$admin->email}}">
                            </td>
                            @foreach($roles as $key=>$role)
                                <td><input type="checkbox" name="{{$role->id}}" {{$admin->hasRole($role->name) ? 'checked' : ''}}/></td>
                            @endforeach
                            <td>
                                <input type="submit" value="Phân quyền" class="btn btn-sm btn-default"/>
                                <a href="{{route('edit-admin',['id'=>$admin->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-pen text-success text-active"></i>
                                </a>
                                <a href="{{route('delete-admin',['id'=>$admin->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                <a href="{{route('view-admin',['id'=>$admin->id])}}" class="active" ui-toggle-class="">
                                    <i class="fa fa-eye text-success text-active"></i>
                                </a>
                            </td>
                        </tr>
                        </form>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
