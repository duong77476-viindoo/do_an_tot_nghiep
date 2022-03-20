<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\PostType;
use App\Models\ProductGroup;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request){
        #region seo
        $meta_desc = "Chuyên smartphone"; //meta desc là phần mô tả bên dưới khi search gg
        $meta_keywords = "BC Phone";
        $meta_title = "BC Phone|SmartPhone blabla";
        $url_canonical = $request->url();
        #end region
        //Danh mục bài viết
        $post_types = PostType::where('status',1)->get();
        //Phân loại sản phẩm
        $category_products = CategoryProduct::where('category_product_status',1)->get();
        //Danh mục cha
        $categories = Category::where('status',1)->get();

        $brands = Brand::where('brand_status',1)->get();
        $sliders = Slider::where('an_hien',1)->get();

        $san_pham_mois = ProductGroup::where('an_hien',1)->get();
        return view('frontend.pages.home')
            ->with('post_types',$post_types)
            ->with('categories',$categories)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('san_pham_mois',$san_pham_mois)
            ->with('sliders',$sliders)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function search(Request $request){
        $meta_desc = "Tìm kiếm sản phẩm"; //meta desc là phần mô tả bên dưới khi search gg
        $meta_keywords = $request->tu_khoa;
        $meta_title = $request->tu_khoa;
        $url_canonical = $request->url();
        $post_types = PostType::where('status',1)->get();
        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $categories = Category::where('status',1)->get();
        $brands = Brand::where('brand_status',1)->get();
        $sliders = Slider::where('an_hien',1)->get();
        $tu_khoa = $request->tu_khoa;
        $san_pham_tim_kiem = ProductGroup::where('an_hien',1)->where('name','like','%'.$tu_khoa.'%')->get();
        return view('frontend.product.search')
            ->with('post_types',$post_types)
            ->with('categories',$categories)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('tu_khoa',$tu_khoa)
            ->with('san_pham_tim_kiem',$san_pham_tim_kiem)
            ->with('sliders',$sliders)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function autocomplete_ajax(Request $request){
        $data = $request->all();
        if($data['query']){
            $san_pham_tim_kiem = ProductGroup::where('an_hien',1)->where('name','like','%'.$data['query'].'%')->get();
            $output = '';
            foreach ($san_pham_tim_kiem as $san_pham){
                $output.='
                    <a href="#" style="cursor: pointer" class="search_product">'.$san_pham->name.'</a>
                ';
            }
            echo $output;
        }
    }
}
