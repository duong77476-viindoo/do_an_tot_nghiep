@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit-product',$product_group) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <h1 class="text-primary">
                    Cập nhật sản phẩm {{$product_group->name}}  {{$product_group->product_group_code}}
                </h1>
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
                                <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-product/'.$product_group->id)}}" method="post" enctype="multipart/form-data">
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
                                                            @if($product_group->brand_id == $brand->id)
                                                                <option selected value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                                            @else
                                                                <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                                            @endif
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
                                                            @if($product_group->nganh_hang_id == $nganh_hang->id)
                                                                <option selected value="{{$nganh_hang->id}}">{{$nganh_hang->name}}</option>
                                                            @else
                                                                <option value="{{$nganh_hang->id}}">{{$nganh_hang->name}}</option>
                                                            @endif
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
                                            <h3 class="card-title">Thông tin chi tiết sản phẩm</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tên nhóm sản phẩm</label>
                                                <input value="{{$product_group->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập tên nhóm sản phẩm">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả ngắn gọn</label>
                                                <input value="{{$product_group->mo_ta_ngan_gon}}" type="text" class="form-control" id="exampleInputEmail1" name="mo_ta_ngan_gon" placeholder="Nhập mô tả ngắn gọn">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Mô tả chi tiết</label>
                                                <textarea id="mo_ta_chi_tiet" style="resize: none" class="form-control" id="exampleInputPassword1" name="mo_ta_chi_tiet" placeholder="Nhập mô tả chi tiết">{{$product_group->mo_ta_chi_tiet}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giá bán</label>
                                                <input value="{{$product_group->gia_ban}}" type="number" class="form-control" id="exampleInputEmail1" name="gia_ban" placeholder="Nhập giá bán">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Ảnh đại diện</label>
                                                <input type="file" class="form-control" id="exampleInputEmail1" name="anh_dai_dien" >
                                                <img src="{{\Illuminate\Support\Facades\URL::to('public/uploads/products/'.$product_group->anh_dai_dien)}}" height="100" width="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Bán chạy</label>
                                                @if($product_group->ban_chay==1)
                                                    <input checked type="checkbox" name="ban_chay">
                                                @else
                                                    <input type="checkbox" name="ban_chay">
                                                @endif

                                                <label for="exampleInputPassword1">Nổi bật</label>
                                                @if($product_group->noi_bat==1)
                                                    <input checked type="checkbox" name="noi_bat">
                                                @else
                                                    <input type="checkbox" name="noi_bat">
                                                @endif
                                                <label for="exampleInputPassword1">Mới về</label>
                                                @if($product_group->moi_ve==1)
                                                    <input checked type="checkbox" name="moi_ve">
                                                @else
                                                    <input type="checkbox" name="moi_ve">
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="phan_loai_san_pham">Phân loại sản phẩm</label>
                                                @foreach($category_products as $category_product)
                                                    {{$category_product->category_product_name}}
                                                    <input id="phan_loai_san_pham" class="" type="checkbox"
                                                           value="{{$category_product->id}}"
                                                           name="category_product_id[]"
                                                           @foreach($product_group->category_products as $item)
                                                           @if($category_product->id == $item->id)
                                                           checked
                                                        @endif
                                                        @endforeach
                                                    >
                                                @endforeach
                                            </div>
                                            <div class="form-group">
                                                <label>Từ khóa sản phẩm</label>
                                                <select multiple id="tags" name="tag_id[]" class="form-control">
                                                    @foreach($tags as $key=>$tag)
                                                        <option
                                                            multiple="true"
                                                            @foreach($product_group->tags as $product_group_tag)
                                                            @if($product_group_tag->id == $tag->id)
                                                            selected
                                                            @endif
                                                            @endforeach
                                                            value="{{$tag->name}}">{{$tag->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Video giới thiệu</label>
                                                <select name="video_id" class="form-control">
                                                    @foreach($videos as $key=>$video)
                                                        @if($product_group->video_id == $video->id)
                                                            <option selected value="{{$video->id}}">{{$video->title}}</option>
                                                        @else
                                                            <option value="{{$video->id}}">{{$video->title}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" name="add_product_group" class="btn btn-info">Cập nhật</button>
                                    </div>
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

