@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                @foreach($products as $product)
                <header class="panel-heading">
                   {{$product->name}}
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
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input disabled value="{{$product->name}}" type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Nhập sản phẩm">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả ngắn gọn</label>
                                    <input disabled value="{{$product->mo_ta_ngan_gon}}" type="text" class="form-control" id="exampleInputEmail1" name="mo_ta_ngan_gon" placeholder="Nhập mô tả ngắn gọn">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả chi tiết</label>
                                    <textarea id="mo_ta_chi_tiet" disabled style="resize: none" class="form-control" id="exampleInputPassword1" name="mo_ta_chi_tiet" placeholder="Nhập mô tả chi tiết">{{$product->mo_ta_chi_tiet}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá bán</label>
                                    <input disabled value="{{$product->gia_ban}}" type="number" class="form-control" id="exampleInputEmail1" name="gia_ban" placeholder="Nhập giá bán">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá cạnh tranh</label>
                                    <input disabled value="{{$product->gia_canh_tranh}}" type="number" class="form-control" id="exampleInputEmail1" name="gia_canh_tranh" placeholder="Nhập giá cạnh tranh">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ảnh đại diện</label>
                                    <input disabled type="file" class="form-control" id="exampleInputEmail1" name="anh_dai_dien" >
                                    <img src="{{\Illuminate\Support\Facades\URL::to('public/uploads/products/'.$product->anh_dai_dien)}}" height="100" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Bán chạy</label>
                                    @if($product->ban_chay==1)
                                        <input disabled checked type="checkbox" name="ban_chay">
                                    @else
                                        <input disabled type="checkbox" name="ban_chay">
                                    @endif

                                    <label for="exampleInputPassword1">Nổi bật</label>
                                    @if($product->noi_bat==1)
                                        <input disabled checked type="checkbox" name="noi_bat">
                                    @else
                                        <input disabled type="checkbox" name="noi_bat">
                                    @endif
                                    <label for="exampleInputPassword1">Mới về</label>
                                    @if($product->moi_ve==1)
                                        <input disabled checked type="checkbox" name="moi_ve">
                                    @else
                                        <input disabled type="checkbox" name="moi_ve">
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="phan_loai_san_pham">Phân loại sản phẩm</label>
                                    @foreach($category_products as $category_product)
                                        {{$category_product->category_product_name}}
                                        <input disabled id="phan_loai_san_pham" class="" type="checkbox"
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
                                    <label>Thương hiệu</label>
                                    <select disabled name="brand_id" class="form-control">
                                        @foreach($brands as $key=>$brand)
                                            @if($product->brand_id == $brand->id)
                                                <option selected value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                            @else
                                                <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                        @endforeach
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
