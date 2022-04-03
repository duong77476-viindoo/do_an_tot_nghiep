@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($nganh_hangs as $nganh_hang)
                    <header class="panel-heading">
                        {{$nganh_hang->name}}
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
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên ngành hàng</label>
                                <input disabled value="{{$nganh_hang->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Code ngành hàng</label>
                                <input disabled value="{{$nganh_hang->code}}" type="text" class="form-control" id="exampleInputEmail1" name="code">
                            </div>

                            @endforeach
                        </div>
                    </div>
            </section>

        </div>
    </div>
@endsection
