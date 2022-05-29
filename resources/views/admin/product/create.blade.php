@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add-product') }}
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
                    Thêm nhóm sản phẩm
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
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin cơ bản sản phẩm</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Date dd/mm/yyyy -->
                                        <div class="form-group">
                                            <label>Thương hiệu:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <select name="brand_id" id="brand_id" class="form-control brand choose">
{{--                                                    <option value="">---Chọn---</option>--}}
                                                @foreach($brands as $key=>$brand)
                                                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->


                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>Ngành hàng:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <select name="nganh_hang_id" id="nganh_hang" class="form-control">
                                                    @foreach($nganh_hangs as $key=>$nganh_hang)
                                                        <option value="{{$nganh_hang->id}}">{{$nganh_hang->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin chi tiết nhóm sản phẩm</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên nhóm sản phẩm</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập sản phẩm">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mô tả ngắn gọn</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="mo_ta_ngan_gon" placeholder="Nhập mô tả ngắn gọn">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Mô tả chi tiết</label>
                                            <textarea id="mo_ta_chi_tiet" style="resize: none" class="form-control" id="exampleInputPassword1" name="mo_ta_chi_tiet" placeholder="Nhập mô tả chi tiết"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ảnh đại diện</label>
                                            <input type="file" class="form-control" id="exampleInputEmail1" name="anh_dai_dien" >
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Bán chạy</label>
                                            <input type="checkbox" name="ban_chay">
                                            <label for="exampleInputPassword1">Nổi bật</label>
                                            <input type="checkbox" name="noi_bat">
                                            <label for="exampleInputPassword1">Mới về</label>
                                            <input type="checkbox" name="moi_ve">
                                        </div>
                                        <div class="form-group">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="trang_thai" id="optionsRadios1" value="1" checked="">
                                                    Còn hàng
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="trang_thai" id="optionsRadios2" value="0">
                                                    Hết hàng
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="an_hien" id="optionsRadios1" value="1" checked="">
                                                    Hiện
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="an_hien" id="optionsRadios2" value="2">
                                                    Ẩn
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tags">Từ khóa sản phẩm</label>
                                            <select class="form-control" multiple id="tags" name="tag_id[]">
                                                @foreach($tags as $key=>$tag)
                                                    <option value="{{$tag->name}}">{{$tag->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="phan_loai_san_pham">Phân loại sản phẩm</label>
                                            @foreach($category_products as $key=>$category_product)
                                                {{$category_product->category_product_name}}
                                                <input id="phan_loai_san_pham" class="" type="checkbox" value="{{$category_product->id}}" name="category_product_id[]">
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label>Video đánh giá</label>
                                            <select name="video_id" class="form-control">
                                                @foreach($videos as $key=>$video)
                                                    <option value="{{$video->id}}">{{$video->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" name="add_product" class="btn btn-info">Thêm</button>
                                </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection

@section('pagescript')
{{--    Scripte tự động khi chọn thương hiệu thì hiển thị những dòng sản phẩm tương ứng--}}
    <script type="text/javascript">
        $(document).ready(function (){
            $('.choose').on('change',function (){
                var action = $(this).attr('id');//
                var id = $(this).val();
                var _token = $('input[name="_token"]').val();
                if(action!=''){
                    var result = 'product_line';
                }
                $('#'+result).selectize()[0].selectize.destroy();
                $.ajax({
                    url: '{{url('/select-product-line')}}',
                    method: 'POST',
                    data: {
                        action:action,
                        id:id,
                        _token:_token
                    },
                    success: function (data,event){
                        $('#'+result).html(data);
                        $('#'+result).selectize({
                            create: true,
                            sortField: "text",
                        });
                    }
                });
            });
        })
    </script>
@endsection
