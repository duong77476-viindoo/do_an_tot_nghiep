<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProductProduct;
use App\Models\Gallery;
use App\Models\NganhHang;
use App\Models\ProductGroup;
use App\Models\CategoryProduct;
use App\Models\Tag;
use App\Models\TagProduct;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\Dumper;
use Symfony\Component\VarDumper\VarDumper;
use function PHPUnit\Framework\exactly;


class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        Paginator::useBootstrap();
        $product_groups = ProductGroup::all();

        return view('admin.product.index')->with('product_groups',$product_groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nganh_hangs = NganhHang::all();
        $tags = Tag::all();
        $brands = Brand::all();
        $videos = Video::all();
        $category_products = CategoryProduct::all();
        return view('admin.product.create')
            ->with('nganh_hangs',$nganh_hangs)
            ->with('tags',$tags)
            ->with('videos',$videos)
            ->with('brands',$brands)
            ->with('category_products',$category_products);
    }

    //Chọn product line để tự động khi chọn thương hiệu thì hiển thị ra
//    public function select_product_line(Request $request){
//        $data = $request->all();
//        if($data['action']){
//            $output='';
//                $product_lines = ProductLine::where('brand_id',$data['id'])->orderby('id','ASC')->get();
//                foreach ($product_lines as $key=>$product_line){
//                    $output .= '<option value="'.$product_line->name.'">'.$product_line->name.'</option>';
//                }
//        }
//        echo $output;
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        $tu_khoa = $request->tag_id;
//        VarDumper::dump($tu_khoa);
//        exit();
        $validated = $request->validate([
            'name' => 'required|min:6|max:100',
            'mo_ta_ngan_gon' => 'required|max:100',
            'mo_ta_chi_tiet' => 'required',
            'anh_dai_dien' => 'required',
            'brand_id'=>'required',
            'category_product_id'=>'required',
            'video_id'=>'required',
            'tag_id'=>'required'
        ]);
        $product_group = new ProductGroup();
        $data = $request->all();

        //Lưu dòng sản phẩm (product line) nếu như là thêm mới (còn nếu select thì chắc ko cần)
//        if($data['product_line']!=''){
////            $product_line = $data['product_line'];
//            $old_product_line = ProductLine::where('name',trim($data['product_line']))->first();
//                if(is_null($old_product_line)){
//                    $product_line = new ProductLine();
//                    $product_line->name = $data['product_line'];
//                    $product_line->brand_id = $data['brand_id'];
//                    $product_line->save();
//                }else{
//                    $product_line = $old_product_line;
//                }
//        }

        //Kiểm tra đã tồn tại sản phẩm ví dụ Iphone 11 bản 8GB-128GB-Red nếu đã có thì ko được thêm
//        $check_old_product_code = array();
//        foreach ($fields as $field){
//           $check_old_product_code[] = $data[$field->name];
//        }
//        $check_old_product = ProductGroup::where('product_line_id',$product_line->id)->where('product_code',implode('-',$check_old_product_code))->first();
//        if(!is_null($check_old_product)){
//            Session::put('message','<p class="text-warning">Đã tồn tại phiên bản sản phẩm '.$data['product_line'].' '.implode('-',$check_old_product_code).'</p>');
//            return Redirect::to('add-product');
//        }



        //Lưu những biến thể sản phẩm : 4GB-64GB-Red
//        $product_code = array();
//        foreach ($fields as $field){
//            $product_variation = new ProductVariation();
//            $product_variation->product_line_id = $product_line->id;
//            $product_variation->name = $field->name;
//            $product_variation->save();
//
//            $product_variation_value = new ProductVariationValue();
//            $product_variation_value->product_variation_id = $product_variation->id;
//            $product_variation_value->name = $data[$field->name];
//            $product_variation_value->save();
//
//            $product_code[] = $data[$field->name];
//        }



        $product_group->name = $data['name'];
        $product_group->nganh_hang_id = $data['nganh_hang_id'];
        $product_group->brand_id = $data['brand_id'];
        $product_group->mo_ta_ngan_gon = $data['mo_ta_ngan_gon'];
        $product_group->mo_ta_chi_tiet = $data['mo_ta_chi_tiet'];
        if($request->has('ban_chay')){
            $product_group->ban_chay = 1;
        }else
            $product_group->ban_chay = 0;
        if($request->has('noi_bat')){
            $product_group->noi_bat = 1;
        }else
            $product_group->noi_bat = 0;
        if($request->has('moi_ve')){
            $product_group->moi_ve = 1;
        }else
            $product_group->moi_ve = 0;
        $product_group->trang_thai = $data['trang_thai'];
        $product_group->an_hien = $data['an_hien'];

        $product_group->video_id = $data['video_id'];
        $product_group->created_at = now();
        $product_group->updated_at = now();

        $path_product_images = 'public/uploads/products/';
        $path_gallery_images = 'public/uploads/gallery/';
        $get_image = $request->file('anh_dai_dien');
        if($get_image){
            $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
            //$image_name = current(explode('.',$get_image_extension));
            $image_name = Str::slug($product_group->name);
            $image = time().'_'.$image_name.'.'.$get_image_extension;
            $get_image->move($path_product_images,$image);
            $product_group->anh_dai_dien = $image;
            \Illuminate\Support\Facades\File::copy($path_product_images.$image,$path_gallery_images.$image);
        }else{
            $product_group->anh_dai_dien = 'no-image.jpeg';
        }
//        VarDumper::dump($product);
//        exit();
        $product_group->save();
        //Sau khi lưu sản phẩm tiến hành lưu từ khóa,tags,
//
        if($data['tag_id']!=''){
            $tags = $data['tag_id'];
            foreach ($tags as $tag){
                $old_tag = Tag::where('name',trim($tag))->first();
                if(!is_null($old_tag))
                    $id_tukhoa = $old_tag->id;
                else{
                    $new_tag = new Tag();
                    $new_tag->name = $tag;
                    $new_tag->save();
                    $id_tukhoa = $new_tag->id;
                }
                $tukhoa_sp = new TagProduct();
                $tukhoa_sp->tag_id = $id_tukhoa;
                $tukhoa_sp->product_group_id = $product_group->id;
                $tukhoa_sp->save();
            }
        }
        //Sau khi lưu sản phẩm mới thì mặc định ảnh sản phẩm sẽ được lưu như 1 ảnh trong gallery sản phẩm
        $gallery = new Gallery();
        $gallery->product_group_id = $product_group->id;
        $gallery->name = $image;
        $gallery->image = $image;
        $gallery->save();

        //sau khi save thì save các phân loại sản phẩm
        foreach ($data['category_product_id'] as $category_product_id){
            $phan_loai_san_pham = new CategoryProductProduct();
            $phan_loai_san_pham->product_group_id=$product_group->id;
            $phan_loai_san_pham->category_product_id = $category_product_id;
            $phan_loai_san_pham->save();
        }
        Session::put('message','<p class="text-success">Thêm sản phẩm thành công</p>');
        return Redirect::to('add-product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $tags = Tag::all();
        $videos = Video::all();
        $category_products = CategoryProduct::all();
        $product_group = ProductGroup::find($id);
        $category_products_id = CategoryProductProduct::where('product_group_id',$id)->get();

//        VarDumper::dump($category_products_id);
//        exit();
        return view('admin.product.view')
            ->with('tags',$tags)
            ->with('videos',$videos)
            ->with('product_group',$product_group)
            ->with('category_products',$category_products)
            ->with('category_products_id',$category_products_id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tags = Tag::all();
        $brands = Brand::all();
        $videos = Video::all();
        $category_products = CategoryProduct::all();
        $product_group = ProductGroup::find($id);

        $category_products_id = CategoryProductProduct::where('product_group_id',$id)->get();

//        VarDumper::dump($category_products_id);
//        exit();
        return view('admin.product.edit')
            ->with('tags',$tags)
            ->with('videos',$videos)
            ->with('brands',$brands)
            ->with('product_group',$product_group)
            ->with('category_products',$category_products)
            ->with('category_products_id',$category_products_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|min:6|max:50',
            'mo_ta_ngan_gon' => 'required|max:50',
            'mo_ta_chi_tiet' => 'required',
            'category_product_id'=>'required',
            'video_id'=>'required',
            'tag_id'=>'required'
        ]);
        $data = $request->all();
        $product = ProductGroup::find($id);
        $product->name = $data['name'];
        $product->mo_ta_ngan_gon = $data['mo_ta_ngan_gon'];
        $product->mo_ta_chi_tiet = $data['mo_ta_chi_tiet'];
        if($request->has('ban_chay')){
            $product->ban_chay = 1;
        }else
            $product->ban_chay = 0;
        if($request->has('noi_bat')){
            $product->noi_bat = 1;
        }else
            $product->noi_bat = 0;
        if($request->has('moi_ve')){
            $product->moi_ve = 1;
        }else
            $product->moi_ve = 0;
        $product->video_id = $data['video_id'];
        //$product->product_slug = API_V1::createCode( $data['product_name']);
        $product->updated_at = now();
        #lưu ảnh
        $get_image = $request->file('anh_dai_dien');
        if($get_image){//nếu cập nhật ảnh mới cần xóa ảnh cũ + unlink
            $anh_cu = $product->anh_dai_dien;
            if($anh_cu!='no-image.jpeg')
                unlink('public/uploads/products/'.$anh_cu);
            $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
            //$image_name = current(explode('.',$get_image_extension));
            $image_name = Str::slug($product->name);
            $image = time().'_'.$image_name.'.'.$get_image_extension;

            $product->anh_dai_dien = $image;//$image tương ứng vói ảnh mới
            $get_image->move('public/uploads/products',$image);
        }


        $product->save();
        //sau khi update thì sẽ xóa hết từ khóa sản phẩm
        TagProduct::where('product_group_id',$product->id)->delete();
        if($data['tag_id']!=''){
            $tags = $data['tag_id'];
            foreach ($tags as $tag){
                $old_tag = Tag::where('name',trim($tag))->first();
                if(!is_null($old_tag))
                    $id_tukhoa = $old_tag->id;
                else{
                    $new_tag = new Tag();
                    $new_tag->name = $tag;
                    $new_tag->save();
                    $id_tukhoa = $new_tag->id;
                }
                $tukhoa_sp = new TagProduct();
                $tukhoa_sp->tag_id = $id_tukhoa;
                $tukhoa_sp->product_group_id = $product->id;
                $tukhoa_sp->save();
            }
        }
        //Sau khi save sản phẩm thì xóa phân loại sản phẩm cũ để cập nhập plsp mới
        //Đã tạo event AfterSave trong model product rồi
        foreach ($data['category_product_id'] as $category_product_id){
            $phan_loai_san_pham = new CategoryProductProduct();
            $phan_loai_san_pham->product_group_id=$product->id;
            $phan_loai_san_pham->category_product_id = $category_product_id;
            $phan_loai_san_pham->save();
        }

        Session::put('message','<p class="text-success">Sửa sản phẩm thành công</p>');
        return Redirect::to('all-product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = ProductGroup::find($id);
        $product->delete();
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-product');
    }

    public function active_product($id){
        ProductGroup::where('id', $id)
            ->update(['an_hien' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-product');
    }

    public function unactive_product($id){

         ProductGroup::where('id', $id)
            ->update(['an_hien' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-product');
    }

    public function con_product($id){
        ProductGroup::where('id', $id)
            ->update(['trang_thai' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-product');
    }

    public function het_product($id){

        ProductGroup::where('id', $id)
            ->update(['trang_thai' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-product');
    }
}
