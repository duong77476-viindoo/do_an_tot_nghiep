<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\CategoryProductProduct;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class SiteController extends Controller
{
    //
    //===================Function cho frontend======================
    public function products_by_category($code, Request $request){
        $post_types = PostType::where('status',1)->get();

        $categories = Category::where('status',1)->get();

        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();
        $category_product = CategoryProduct::where('code',$code)->first();
        $sanphams_by_category = $category_product->product_groups;
        $sliders = Slider::where('an_hien',1)->get();

        $meta_desc = $category_product->category_product_desc;
        $meta_keywords = $category_product->meta_keywords;
        $meta_title = $category_product->category_product_name;
        $url_canonical = $request->url();

        return view('frontend.category.products_by_category')
            ->with('post_types',$post_types)
            ->with('categories',$categories)
            ->with('category_product',$category_product)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('sanphams_by_category',$sanphams_by_category)
            ->with('sliders',$sliders)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function products_by_brand($code, Request $request){
        $post_types = PostType::where('status',1)->get();

        $categories = Category::where('status',1)->get();

        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();
        $brand = Brand::where('brand_slug',$code)->first();
        $sanphams_by_brand = $brand->product_groups;
        $sliders = Slider::where('an_hien',1)->get();


        $meta_desc = $brand->brand_desc;
        $meta_keywords = $brand->meta_keywords;
        $meta_title = $brand->brand_name;
        $url_canonical = $request->url();
//        foreach ($category_product->products as $product)
//            dd($product);
        return view('frontend.brand.products_by_brand')
            ->with('post_types',$post_types)
            ->with('categories',$categories)
            ->with('brand',$brand)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('sanphams_by_brand',$sanphams_by_brand)
            ->with('sliders',$sliders)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function product_by_id($code, Request $request){
        $post_types = PostType::where('status',1)->get();

        $categories = Category::where('status',1)->get();

        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();

//        $san_pham_chi_tiet = ProductGroup::where('code',$code)->first();
        $phien_ban_san_pham = Product::where('code',$code)->first();
        $nhom_san_pham = ProductGroup::where('id',$phien_ban_san_pham->product_group_id)->first();
        $sliders = Slider::where('an_hien',1)->get();


        $meta_desc = $nhom_san_pham->mo_ta_ngan_gon;
        $meta_keywords = $nhom_san_pham->meta_keywords;
        $meta_title = $nhom_san_pham->name;
        $url_canonical = $request->url();


        $san_pham_lien_quan = array();
        foreach ($nhom_san_pham->category_products as $category_product){
            $san_pham_lien_quan[] = CategoryProductProduct::where('category_product_id',$category_product->id)
            ->where('product_group_id','!=',$nhom_san_pham->id)->get();
        }
        $id_san_pham = array();
//        VarDumper::dump($san_pham_lien_quan);
//        exit();
        foreach ($san_pham_lien_quan as $san_pham)
            foreach ($san_pham as $item)
                $id_san_pham[]=$item->product_group_id;

        //VarDumper::dump(array_unique($id_san_pham));
        $san_phams_lien_quan = ProductGroup::find($id_san_pham);
//        VarDumper::dump($san_phams_lien_quan);
//        foreach ($san_phams_lien_quan as $san_pham)
//            VarDumper::dump($san_pham->anh_dai_dien);
//        exit();


        return view('frontend.product.chi-tiet-san-pham')
            ->with('post_types',$post_types)
            ->with('categories',$categories)
            ->with('phien_ban_san_pham',$phien_ban_san_pham)
            ->with('nhom_san_pham',$nhom_san_pham)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('san_phams_lien_quan',$san_phams_lien_quan)
            ->with('sliders',$sliders)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function danh_muc_bai_viet($code, Request $request){
        $post_types = PostType::where('status',1)->get();
        $categories = Category::where('status',1)->get();

        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();

        $sliders = Slider::where('an_hien',1)->get();
        $post_type = PostType::where('code',$code)->first();

        Paginator::useBootstrap();
        $posts = Post::where('post_type_id',$post_type->id)->where('status',1)->paginate(4);

        $meta_desc = $post_type->desc;
        $meta_keywords = $post_type->meta_keywords;
        $meta_title = $post_type->name;
        $url_canonical = $request->url();
        return view('frontend.post.post_type')->with(compact('post_type'))
            ->with('post_types',$post_types)
            ->with('posts',$posts)
            ->with('categories',$categories)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('sliders',$sliders)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function chi_tiet_bai_viet($danh_muc, $bai_viet,Request $request){
        $post_types = PostType::where('status',1)->get();
        $categories = Category::where('status',1)->get();

        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();

        $sliders = Slider::where('an_hien',1)->get();

        $post_type = PostType::where('code',$danh_muc)->first();
        $post = Post::where('code',$bai_viet)->first();

        $related_posts = Post::where('post_type_id',$post_type->id)
            ->where('id','!=',$post->id)
            ->get();

        $meta_desc = $post->desc;
        $meta_keywords = $post->meta_keywords;
        $meta_title = $post->name;
        $url_canonical = $request->url();
        return view('frontend.post.post')
            ->with('post_types',$post_types)
            ->with('categories',$categories)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('sliders',$sliders)
            ->with(compact('post_type'))
            ->with('post',$post)
            ->with('related_posts',$related_posts)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function watch_video(Request $request){
        $data = $request->all();
        $video_id = $data['video_id'];
        $video = Video::find($video_id);
        $output['video_title'] = $video->title;
        $output['video_desc'] = $video->desc;
//        $output['video_link'] = ' <iframe width="100%"
//                                height="315"
//                                src="https://www.youtube.com/embed/'.$video->link.'?autoplay=1"
//                                title="YouTube video player"
//                                frameborder="0"
//                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
//                                allowfullscreen>
//                                </iframe>';
        $output['video_link']='<div id="youtube_review" class="vlite-js" data-youtube-id="'.$video->link.'"></div>';
        echo json_encode($output);
    }

    public function products_by_tag(Request $request, $code){
        $post_types = PostType::where('status',1)->get();

        $categories = Category::where('status',1)->get();

        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();
        $tag = Tag::where('code',$code)->first();
        $sanphams_by_tag = $tag->products;
        $sliders = Slider::where('an_hien',1)->get();


        $meta_desc = $tag->desc;
        $meta_keywords = $tag->meta_keywords;
        $meta_title = $tag->name;
        $url_canonical = $request->url();
//        foreach ($category_product->products as $product)
//            dd($product);
        return view('frontend.product.products_by_tag')
            ->with('post_types',$post_types)
            ->with('categories',$categories)
            ->with('tag',$tag)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('sanphams_by_tag',$sanphams_by_tag)
            ->with('sliders',$sliders)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function quick_view(Request $request){
        $product_id = $request->product_id;
        $product = ProductGroup::find($product_id);

        $gallery = Gallery::where('product_id',$product_id)->get();

        $output['product_gallery']='';
        foreach ($gallery as $gal){
            $output['product_gallery'].='<p><img width="100%" src="'.asset('public/uploads/gallery/'.$gal->image).'" alt="'.$gal->name.'"></p>';
        }

        $output['product_name'] = $product->name;
        $output['product_id'] = $product->id;
        $output['product_desc'] = $product->mo_ta_ngan_gon;
        $output['product_content'] = $product->mo_ta_chi_tiet;
        $output['product_price']= number_format($product->gia_ban,0,',','.').' VND';
        $output['product_image']='<p><img width="100%" src="'.asset('public/uploads/products/'.$product->anh_dai_dien).'" alt="'.$product->name.'"></p>';

        $output['product_quickview_button'] = '
             <input type="button" value="Mua ngay" class="btn btn-primary  add-to-cart-quickview"
                                   data-product_id="'.$product->id.'" name="add-to-cart">
        ';

        $output['product_quickview_value']='
            <input type="hidden"  class="cart_product_id_'.$product->id.'" value="'.$product->id.'">
            <input type="hidden"  class="cart_product_name_'.$product->id.'" value="'.$product->name.'">
            <input type="hidden"  class="cart_product_image_'.$product->id.'" value="'.$product->anh_dai_dien.'">
            <input type="hidden"  class="cart_product_price_'.$product->id.'" value="'.$product->gia_ban.'">
            <input type="hidden"  class="product_qty_'.$product->id.'" value="'.$product->so_luong.'">
        ';

        $output['product_quickview_cartQty'] = '<input name="so_luong" type="number" min="1" class="cart_product_qty_'.$product->id.'" value="1">';

        $output['go_to_product_detail'] = '<a class="btn btn-primary" href="'.route('product',['code'=>$product->code]).'">Đi tới sản phẩm</a>';

        echo json_encode($output);
    }
}

