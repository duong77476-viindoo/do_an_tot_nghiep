<div class="left-sidebar">
    <h2>Danh mục sản phẩm</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        @foreach($categories as $key=>$category)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordian" href="#{{$category->code}}">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        {{$category->name}}
                    </a>
                </h4>
            </div>
            <div id="{{$category->code}}" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        @foreach($category->category_products as $category_product)
                        <li><a href="{{route('danh-muc-san-pham',['code'=>$category_product->code])}}">{{$category_product->category_product_name}} </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div><!--/category-products-->

    <div class="brands_products"><!--brands_products-->
        <h2>Thương hiệu</h2>
        <div class="brands-name">
            <ul class="nav nav-pills nav-stacked">
                @foreach($brands as $brand)
                <li><a href="{{route('thuong-hieu',['code'=>$brand->brand_slug])}}"> <span class="pull-right">(50)</span>{{$brand->brand_name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div><!--/brands_products-->

    <div class="price-range"><!--price-range-->
        <h2>Price Range</h2>
        <div class="well text-center">
            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
            <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
        </div>
    </div><!--/price-range-->

    <div class="shipping text-center"><!--shipping-->
        <img src="images/home/shipping.jpg" alt="" />
    </div><!--/shipping-->

</div>
