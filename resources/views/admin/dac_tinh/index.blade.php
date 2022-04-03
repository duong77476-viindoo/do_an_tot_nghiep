@extends('admin.admin_layout')
@section('admin_content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm đặc tính cho ngành hàng {{$nganh_hang->name}}
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{route('save-dac-tinh')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên đặc tính</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên đặc tính">
                            </div>
                            <input type="hidden" name="nganh_hang_id" value="{{$nganh_hang->id}}">
                            <button type="submit" name="add_dac_tinh" class="btn btn-info">Thêm</button>
                        </form>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped b-t b-light">
                                <thead>
                                <tr>
                                    <th style="width:20px;">
                                        <label class="i-checks m-b-none">
                                            <input type="checkbox"><i></i>
                                        </label>
                                    </th>
                                    <th>Tên đặc tính</th>
                                    <th>Code đặc tính</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dac_tinhs as $key => $dac_tinh)
                                    <tr>
                                        <td><label class="i-checks m-b-none"><input type="checkbox" name="dac_tinh[]"><i></i></label></td>
                                        <td>{{$dac_tinh->name}}</td>
                                        <td>{{$dac_tinh->code}}</td>
                                        <td>{{$dac_tinh->updated_at}}</td>
                                        <td>
                                            <a href="{{route('delete-dac-tinh',['id'=>$dac_tinh->id])}}"
                                               onclick="return confirm('Bạn có chắc muốn xóa?')"
                                               class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
