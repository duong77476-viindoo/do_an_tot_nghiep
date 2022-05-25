@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('edit-phieu-nhap',$phieu_nhap) }}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <h1 class="text-primary">
                    Cập nhật sản phẩm {{$product->name}}  {{$product->product_code}}
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
                                <form role="form" action="{{\Illuminate\Support\Facades\URL::to('/update-product/'.$product->id)}}" method="post" enctype="multipart/form-data">
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
                                                    <select disabled name="brand_id" id="brand_id" class="form-control brand choose">
                                                            <option value="{{$brand_product}}">{{$brand_product}}</option>
                                                    </select>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->


                                            <!-- phone mask -->
                                            <div class="form-group">
                                                <label>Dòng sản phẩm:</label>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    </div>
                                                    <select disabled name="product_line" id="product_line" class="form-control product_line">
                                                        <option value="">{{$product->product_line->name}}</option>
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
                                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                                <input value="{{$product->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập sản phẩm">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả ngắn gọn</label>
                                                <input value="{{$product->mo_ta_ngan_gon}}" type="text" class="form-control" id="exampleInputEmail1" name="mo_ta_ngan_gon" placeholder="Nhập mô tả ngắn gọn">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Mô tả chi tiết</label>
                                                <textarea id="mo_ta_chi_tiet" style="resize: none" class="form-control" id="exampleInputPassword1" name="mo_ta_chi_tiet" placeholder="Nhập mô tả chi tiết">{{$product->mo_ta_chi_tiet}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giá bán</label>
                                                <input value="{{$product->gia_ban}}" type="number" class="form-control" id="exampleInputEmail1" name="gia_ban" placeholder="Nhập giá bán">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Giá cạnh tranh</label>
                                                <input value="{{$product->gia_canh_tranh}}" type="number" class="form-control" id="exampleInputEmail1" name="gia_canh_tranh" placeholder="Nhập giá cạnh tranh">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Ảnh đại diện</label>
                                                <input type="file" class="form-control" id="exampleInputEmail1" name="anh_dai_dien" >
                                                <img src="{{\Illuminate\Support\Facades\URL::to('public/uploads/products/'.$product->anh_dai_dien)}}" height="100" width="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Bán chạy</label>
                                                @if($product->ban_chay==1)
                                                    <input checked type="checkbox" name="ban_chay">
                                                @else
                                                    <input type="checkbox" name="ban_chay">
                                                @endif

                                                <label for="exampleInputPassword1">Nổi bật</label>
                                                @if($product->noi_bat==1)
                                                    <input checked type="checkbox" name="noi_bat">
                                                @else
                                                    <input type="checkbox" name="noi_bat">
                                                @endif
                                                <label for="exampleInputPassword1">Mới về</label>
                                                @if($product->moi_ve==1)
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
                                                           @foreach($category_products_id as $item)
                                                           @if($category_product->id == $item->category_product_id)
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
                                                            @foreach($product->tags as $product_tag)
                                                            @if($product_tag->id == $tag->id)
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
                                                        @if($product->video_id == $video->id)
                                                            <option selected value="{{$video->id}}">{{$video->title}}</option>
                                                        @else
                                                            <option value="{{$video->id}}">{{$video->title}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" name="add_product" class="btn btn-info">Cập nhật</button>
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

