@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('fee-ship') }}
    <div class="row">
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm phí vận chuyển
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
                        <form id="form-fee-ship" action="" method="post">
                            {{csrf_field()}}

                            <div class="form-group">
                               <label>Chọn tỉnh thành phố</label>
                               <select name="city" id="city" class="form-control choose city">

                                   <option value="">---Chọn---</option>
                                   @foreach($cities as $key=>$city)
                                       <option value="{{$city->id}}">{{$city->name}}</option>
                                   @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                                <label>Chọn quận huyện</label>
                                <select name="province" id="province" class="form-control choose province">
                                    <option value="">---Chọn---</option>
                                </select>
                            </div> <div class="form-group">
                                <label>Chọn xã phường</label>
                                <select name="ward" id="ward" class="form-control ward">
                                    <option value="">---Chọn---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nhập phi vận chuyển</label>
                               <input type="number" name="fee_ship" class="form-control fee_ship" placeholder="Nhập phí vận chuyển">
                            </div>
                            <button type="button" name="add_fee_ship" class="btn btn-info add_fee_ship">Thêm phí vận chuyển</button>
                        </form>
                    </div>
                    <div id="load-fee-ship">

                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
