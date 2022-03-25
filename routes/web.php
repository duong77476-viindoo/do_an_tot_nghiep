<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\VideoController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Sendportal\Base\Facades\Sendportal;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//========FRONTEND================
Route::get('/',[HomeController::class,'index']);
Route::get('/trang-chu',[HomeController::class,'index'])->name('trang-chu');
Route::get('/contact',[HomeController::class,'contact'])->name('contact');
Route::post('/tim-kiem',[HomeController::class,'search'])->name('tim-kiem');
Route::post('/autocomplete-ajax',[HomeController::class,'autocomplete_ajax'])->name('autocomplete-ajax');
//Xem nhanh sản phẩm
Route::post('/quickview',[SiteController::class,'quick_view'])->name('quick-view');



//Danh mục bài viết và bài viết
Route::get('/danh-muc-bai-viet/{code}',[SiteController::class,'danh_muc_bai_viet'])->name('danh-muc-bai-viet');
Route::get('/danh_muc_{danh_muc}/{bai_viet}',[SiteController::class,'chi_tiet_bai_viet'])->name('chi-tiet-bai-viet');
//Khách hàng
Route::post('/add-customer',[CustomerController::class,'store'])->name('add-customer');
Route::get('/login',[CustomerController::class,'create'])->name('login');
Route::get('/logout-customer',[CustomerController::class,'logout'])->name('logout-customer');
Route::post('/login-customer',[CustomerController::class,'login_customer'])->name('login-customer');
Route::get('/account',[CustomerController::class,'create'])->name('account');

//Mã giảm giá
Route::post('/check-coupon',[CouponController::class,'check_coupon'])->name('check-coupon');
Route::get('/delete-coupon',[CouponController::class,'delete_coupon'])->name('delete-coupon');

//Giỏ hàng
Route::post('/add-cart-ajax',[CartController::class,'add_cart_ajax'])->name('add-cart-ajax');
Route::get('/gio-hang',[CartController::class,'gio_hang'])->name('gio-hang');

Route::post('/save-cart',[CartController::class,'save_cart'])->name('save-cart');
Route::get('/show-cart',[CartController::class,'show_cart'])->name('show-cart');
Route::get('/delete-cart-item/{id}',[CartController::class,'delete_cart_item'])->name('delete-cart-item');
Route::post('/update-cart-quantity',[CartController::class,'update_cart_quantity'])->name('update-cart-quantity');
Route::post('/update-cart-ajax',[CartController::class,'update_cart_ajax'])->name('update-cart-ajax');
Route::get('/delete-cart-product/{session_id}',[CartController::class,'delete_cart_product'])->name('delete-cart-product');
Route::get('/delete-all-cart',[CartController::class,'delete_all_cart'])->name('delete-all-cart');


//Thanh toán
Route::get('/login-checkout',[CheckoutController::class,'login_checkout'])->name('login-checkout');
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('/save-checkout',[CheckoutController::class,'save_checkout'])->name('save-checkout');
Route::get('/payment',[CheckoutController::class,'payment'])->name('payment');
Route::post('/customer-order',[CheckoutController::class,'customer_order'])->name('customer-order');

Route::post('/confirm-order',[CheckoutController::class,'confirm_order'])->name('confirm-order');

//Tính phí vận chuyển khi cbi thanh toán
Route::post('/select-province-ward-frontend',[CheckoutController::class,'select_province_ward_home'])->name('select-province-ward-frontend');
Route::post('/calculate-fee-ship',[CheckoutController::class,'calculate_fee_ship'])->name('calculate-fee-ship');
Route::get('/delete-fee',[CheckoutController::class,'delete_fee'])->name('delete-fee');

//Xem video
Route::post('/watch-video',[SiteController::class,'watch_video'])->name('watch-video');

//Tag sản phẩm
Route::get('/tag/{code}',[SiteController::class,'products_by_tag'])->name('tag');

//Sản phẩm theo thương hiệu
Route::get('/thuong-hieu/{code}',[SiteController::class,'products_by_brand'])
    ->name('thuong-hieu');


//Sản phẩm theo phân loại danh mục
Route::get('/danh-muc-san-pham/{code}',[SiteController::class,'products_by_category'])
    ->name('danh-muc-san-pham');

//Chi tiết sản phẩm
Route::get('/product/{code}',[SiteController::class,'product_by_id'])
    ->name('product');





//========BACKEND===============
Route::get('/admin',[AdminController::class,'index'])->name('admin');

//Đăng nhập dùng auth
Route::post('/login-admin',[AdminController::class,'login_admin'])->name('login-admin');
Route::post('/admin_dashboard',[AdminController::class,'admin_dashboard']);//đăng nhập không dùng auth


//Đăng ký người dùng, phân quyền
Route::middleware('check_login_admin')->group(function (){
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');


    Route::post('/save-admin',[AdminController::class,'save_admin'])->name('save-admin');
    Route::get('/logout-admin',[AdminController::class,'logout_admin'])->name('logout-admin');//logout auth
    Route::get('/logout',[AdminController::class,'logout'])->name('logout');//logout bình thường

    Route::group(['middleware'=>'admin:Admin'],function (){
        Route::get('/register-admin',[AdminController::class,'register_admin'])->name('register-admin');
        Route::get('/view-admin-users',[AdminController::class,'view_admin_users'])->name('view-admin-users');
        Route::get('/edit-admin/{id}',[AdminController::class,'edit'])->name('edit-admin');
        Route::get('/delete-admin/{id}',[AdminController::class,'destroy'])->name('delete-admin');
        Route::get('/view-admin/{id}',[AdminController::class,'show'])->name('view-admin');
        Route::post('/update-admin/{id}',[AdminController::class,'update'])->name('update-admin');

        Route::post('/assign-roles',[AdminController::class,'assign_roles'])->name('assign-roles');
    });
});

//Loại phân loại (danh mục cha)
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-category',[CategoryController::class,'index'])->name('all-category');
    Route::get('/add-category',[CategoryController::class,'create'])->name('add-category');
    Route::get('/edit-category/{id}',[CategoryController::class,'edit'])->name('edit-category');
    Route::get('/delete-category/{id}',[CategoryController::class,'destroy'])->name('delete-category');
    Route::post('/update-category/{id}',[CategoryController::class,'update'])->name('update-category');
    Route::get('/view-category/{id}',[CategoryController::class,'show'])->name('view-category');


    Route::post('/save-category',[CategoryController::class,'store'])->name('save-category');

    Route::get('/active-category/{id}',[CategoryController::class,'active_category'])->name('active-category');
    Route::get('/unactive-category/{id}',[CategoryController::class,'unactive_category'])->name('unactive-category');

    //import export excel
    Route::post('/category/import-csv',[CategoryController::class,'import_csv'])->name('category-import-csv');
    Route::post('/category/export-csv',[CategoryController::class,'export_csv'])->name('category-export-csv');

});

//Phân loại sản phẩm
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-category-product',[CategoryProductController::class,'index'])->name('all-category-product');
    Route::get('/add-category-product',[CategoryProductController::class,'create'])->name('add-category-product');
    Route::get('/edit-category-product/{id}',[CategoryProductController::class,'edit'])->name('edit-category-product');
    Route::get('/delete-category-product/{id}',[CategoryProductController::class,'destroy'])->name('delete-category-product');
    Route::post('/update-category-product/{id}',[CategoryProductController::class,'update'])->name('update-category-product');
    Route::get('/view-category-product/{id}',[CategoryProductController::class,'show'])->name('view-category-product');


    Route::post('/save-category-product',[CategoryProductController::class,'store'])->name('save-category-product');

    Route::get('/active-category-product/{id}',[CategoryProductController::class,'active_category_product'])->name('active-category-product');
    Route::get('/unactive-category-product/{id}',[CategoryProductController::class,'unactive_category_product'])->name('unactive-category-product');

    //import export excel
    Route::post('/category-product/import-csv',[CategoryProductController::class,'import_csv'])->name('category-import-csv');
    Route::post('/category-product/export-csv',[CategoryProductController::class,'export_csv'])->name('category-export-csv');

});


//Brand thương hiệu
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-brand',[BrandController::class,'index'])->name('all-brand');
    Route::get('/add-brand',[BrandController::class,'create'])->name('add-brand');
    Route::get('/edit-brand/{id}',[BrandController::class,'edit'])->name('edit-brand');
    Route::get('/delete-brand/{id}',[BrandController::class,'destroy'])->name('delete-brand');
    Route::post('/update-brand/{id}',[BrandController::class,'update'])->name('update-brand');
    Route::get('/view-brand/{id}',[BrandController::class,'show'])->name('view-brand');


    Route::post('/save-brand',[BrandController::class,'store'])->name('save-brand');

    Route::get('/active-brand/{id}',[BrandController::class,'active_brand'])->name('active-brand');
    Route::get('/unactive-brand/{id}',[BrandController::class,'unactive_brand'])->name('unactive-brand');
});

//Danh mục Bài viết
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-post-type',[PostTypeController::class,'index'])->name('all-post-type');
    Route::get('/add-post-type',[PostTypeController::class,'create'])->name('add-post-type');
    Route::get('/edit-post-type/{id}',[PostTypeController::class,'edit'])->name('edit-post-type');
    Route::get('/delete-post-type/{id}',[PostTypeController::class,'destroy'])->name('delete-post-type');
    Route::post('/update-post-type/{id}',[PostTypeController::class,'update'])->name('update-post-type');
    Route::get('/view-post-type/{id}',[PostTypeController::class,'show'])->name('view-post-type');


    Route::post('/save-post-type',[PostTypeController::class,'store'])->name('save-post-type');

    Route::get('/active-post-type/{id}',[PostTypeController::class,'active_post_type'])->name('active-post-type');
    Route::get('/unactive-post-type/{id}',[PostTypeController::class,'unactive_post_type'])->name('unactive-post-type');

    //import export excel
    Route::post('/post-type/import-csv',[PostTypeController::class,'import_csv'])->name('post-type-import-csv');
    Route::post('/post-type/export-csv',[PostTypeController::class,'export_csv'])->name('post-type-export-csv');

});

//Bài viết
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-post',[PostController::class,'index'])->name('all-post');
    Route::get('/add-post',[PostController::class,'create'])->name('add-post');
    Route::get('/edit-post/{id}',[PostController::class,'edit'])->name('edit-post');
    Route::get('/delete-post/{id}',[PostController::class,'destroy'])->name('delete-post');
    Route::post('/update-post/{id}',[PostController::class,'update'])->name('update-post');
    Route::get('/view-post/{id}',[PostController::class,'show'])->name('view-post');


    Route::post('/save-post',[PostController::class,'store'])->name('save-post');

    Route::get('/active-post/{id}',[PostController::class,'active_post'])->name('active-post');
    Route::get('/unactive-post/{id}',[PostController::class,'unactive_post'])->name('unactive-post');

    //import export excel
    Route::post('/post/import-csv',[PostController::class,'import_csv'])->name('post-import-csv');
    Route::post('/post/export-csv',[PostController::class,'export_csv'])->name('post-export-csv');

});


//Nhóm Sản phẩm
Route::middleware('check_login_admin')->group(function (){

    Route::get('/all-product',[ProductGroupController::class,'index'])->name('all-product');
    Route::get('/add-product',[ProductGroupController::class,'create'])->name('add-product');
    Route::get('/edit-product/{id}',[ProductGroupController::class,'edit'])->name('edit-product');
    Route::get('/delete-product/{id}',[ProductGroupController::class,'destroy'])->name('delete-product');
    Route::post('/update-product/{id}',[ProductGroupController::class,'update'])->name('update-product');
    Route::get('/view-product/{id}',[ProductGroupController::class,'show'])->name('view-product');

    Route::post('/save-product',[ProductGroupController::class,'store'])->name('save-product');

    Route::post('/select-product-line',[ProductGroupController::class,'select_product_line'])->name('select-product-line');


    Route::get('/active-product/{id}',[ProductGroupController::class,'active_product'])->name('active-product');
    Route::get('/unactive-product/{id}',[ProductGroupController::class,'unactive_product'])->name('unactive-product');

    Route::get('/con-product/{id}',[ProductGroupController::class,'con_product'])->name('con-product');
    Route::get('/het-product/{id}',[ProductGroupController::class,'het_product'])->name('het-product');

    //Thêm product_spec theo thầy
    Route::get('/add-product-spec/{id}',[ProductController::class,'add_product_spec'])->name('add-product-spec');
    Route::post('/insert-product-spec/{id}',[ProductController::class,'insert_product_spec'])->name('insert-product-spec');
    Route::post('/select-product-spec',[ProductController::class,'select_product_spec'])->name('select-product-spec');

});

//Gallery sản phẩm
Route::middleware('check_login_admin')->group(function (){

//    Route::get('/all-gallery',[GalleryController::class,'index'])->name('all-gallery');
    Route::get('/add-gallery/{id}',[GalleryController::class,'add_gallery'])->name('add-gallery');
    Route::post('/select-gallery',[GalleryController::class,'select_gallery'])->name('select-gallery');
    Route::post('/insert-gallery/{id}',[GalleryController::class,'insert_gallery'])->name('insert-gallery');
    Route::post('/update-gallery-name',[GalleryController::class,'update_gallery_name'])->name('update-gallery-name');
    Route::post('/delete-gallery',[GalleryController::class,'delete_gallery'])->name('delete-gallery');
    Route::post('/update-gallery',[GalleryController::class,'update_gallery'])->name('/update-gallery');

    //    Route::get('/edit-gallery/{id}',[GalleryController::class,'edit'])->name('edit-gallery');
//    Route::get('/delete-gallery/{id}',[GalleryController::class,'destroy'])->name('delete-gallery');
//    Route::post('/update-gallery/{id}',[GalleryController::class,'update'])->name('update-gallery');
//    Route::get('/view-gallery/{id}',[GalleryController::class,'show'])->name('view-gallery');
//
//    Route::post('/save-gallery',[GalleryController::class,'store'])->name('save-gallery');
//
//    Route::get('/active-gallery/{id}',[GalleryController::class,'active_gallery'])->name('active-gallery');
//    Route::get('/unactive-gallery/{id}',[GalleryController::class,'unactive_gallery'])->name('unactive-gallery');


});

//Video
Route::middleware('check_login_admin')->group(function (){

    Route::get('/all-video',[VideoController::class,'index'])->name('all-video');
    Route::post('/select-video',[VideoController::class,'select_video'])->name('select-video');
    Route::post('/insert-video',[VideoController::class,'insert_video'])->name('insert-video');
    Route::post('/update-video',[VideoController::class,'update_video'])->name('update-video');
    Route::post('/delete-video',[VideoController::class,'delete_video'])->name('delete-video');
    Route::post('/update-video-image',[VideoController::class,'update_video_image'])->name('update-video-image');

//    Route::get('/add-video',[VideoController::class,'create'])->name('add-video');
//    Route::get('/edit-video/{id}',[VideoController::class,'edit'])->name('edit-video');
//    Route::get('/delete-video/{id}',[VideoController::class,'destroy'])->name('delete-video');
//    Route::post('/update-video/{id}',[VideoController::class,'update'])->name('update-video');
//    Route::get('/view-video/{id}',[VideoController::class,'show'])->name('view-video');
//
//    Route::post('/save-video',[VideoController::class,'store'])->name('save-video');
//
//    Route::get('/active-video/{id}',[VideoController::class,'active_video'])->name('active-video');
//    Route::get('/unactive-video/{id}',[VideoController::class,'unactive_video'])->name('unactive-video');

});

//Slider
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-slider',[SliderController::class,'index'])->name('all-slider');
    Route::get('/add-slider',[SliderController::class,'create'])->name('add-slider');
    Route::get('/edit-slider/{id}',[SliderController::class,'edit'])->name('edit-slider');
    Route::get('/delete-slider/{id}',[SliderController::class,'destroy'])->name('delete-slider');
    Route::post('/update-slider/{id}',[SliderController::class,'update'])->name('update-slider');
    Route::get('/view-slider/{id}',[SliderController::class,'show'])->name('view-slider');


    Route::post('/save-slider',[SliderController::class,'store'])->name('save-slider');

    Route::get('/active-slider/{id}',[SliderController::class,'active_slider'])->name('active-slider');
    Route::get('/unactive-slider/{id}',[SliderController::class,'unactive_slider'])->name('unactive-slider');
});

//Coupon mã giảm giá
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-coupon',[CouponController::class,'index'])->name('all-coupon');
    Route::get('/add-coupon',[CouponController::class,'create'])->name('add-coupon');
    Route::get('/edit-coupon/{id}',[CouponController::class,'edit'])->name('edit-coupon');
    Route::get('/delete-coupon/{id}',[CouponController::class,'destroy'])->name('delete-coupon');
    Route::post('/update-coupon{id}',[CouponController::class,'update'])->name('update-coupon');
    Route::get('/view-coupon/{id}',[CouponController::class,'show'])->name('view-coupon');


    Route::post('/save-coupon',[CouponController::class,'store'])->name('save-coupon');

    Route::get('/active-coupon/{id}',[CouponController::class,'active_brand'])->name('active-coupon');
    Route::get('/unactive-coupon/{id}',[CouponController::class,'unactive_brand'])->name('unactive-coupon');
});

//Hóa đơn bán
Route::middleware('check_login_admin')->group(function (){
    Route::get('/all-customer-order',[OrderController::class,'index'])->name('all-customer-order');

    Route::get('/edit-customer-order/{id}',[OrderController::class,'edit'])->name('edit-customer-order');
    Route::get('/delete-customer-order/{id}',[OrderController::class,'destroy'])->name('delete-customer-order');
    Route::post('/update-customer-order/{id}',[OrderController::class,'update'])->name('update-customer-order');
    Route::get('/view-customer-order/{id}',[OrderController::class,'show'])->name('view-customer-order');

    Route::get('/print-order/{id}',[OrderController::class,'print_order'])->name('print-order');

    Route::post('/update-order-status',[OrderController::class,'update_order_status'])->name('update-order-status');
//Vận chuyển
    Route::get('/fee-ship',[DeliveryController::class,'fee_ship'])->name('fee-ship');
    Route::post('/select-province-ward',[DeliveryController::class,'select_province_ward'])->name('select-province-ward');
    Route::post('/add-fee-ship',[DeliveryController::class,'add_fee_ship'])->name('add-fee-ship');
    Route::post('/load-fee-ship',[DeliveryController::class,'load_fee_ship'])->name('load-fee-ship');
    Route::post('/update-fee-ship',[DeliveryController::class,'update_fee_ship'])->name('update-fee-ship');

});

//module email marketing
Route::middleware('check_login_admin')->prefix('sendportal')->group(function () {
        Sendportal::webRoutes();
});
Sendportal::publicWebRoutes();


//Gửi mail test
Route::get('/send-mail',[MailController::class,'send_mail']);

//Đăng nhập facebook
Route::get('/login-facebook',[AdminController::class,'login_facebook'])->name('login-facebook');
Route::get('/admin/callback',[AdminController::class,'callback_facebook']);

//Đăng nhập google
Route::get('/login-google',[AdminController::class,'login_google'])->name('login-google');
Route::get('/google/callback',[AdminController::class,'callback_google']);







