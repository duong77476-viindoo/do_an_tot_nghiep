<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

//Dashboard
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->push('Admin', route('admin'));
});

//Người dùng
Breadcrumbs::register('user', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Người dùng',route('view-admin-users'));
});

Breadcrumbs::register('view_user', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('user');
    $breadcrumbs->push($user->name,route('view-admin',['id'=>$user->id]));
});

Breadcrumbs::register('edit_user', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('user');
    $breadcrumbs->push($user->name,route('edit-admin',['id'=>$user->id]));
});

//Nhà cung cấp
Breadcrumbs::register('provider', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Nhà cung cấp',route('all-nha-cung-cap'));
});

Breadcrumbs::register('add_provider', function ($breadcrumbs) {
    $breadcrumbs->parent('provider');
    $breadcrumbs->push('Thêm nhà cung cấp',route('add-nha-cung-cap'));
});

Breadcrumbs::register('view_provider', function ($breadcrumbs, $provider) {
    $breadcrumbs->parent('provider');
    $breadcrumbs->push($provider->name, route('view-nha-cung-cap', ['id' => $provider->id]));
});

Breadcrumbs::register('edit_provider', function ($breadcrumbs, $provider) {
    $breadcrumbs->parent('provider');
    $breadcrumbs->push($provider->name,route('edit-nha-cung-cap',['id'=>$provider->id]));
});

//Ngành hàng
Breadcrumbs::register('nganh_hang', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Ngành hàng',route('all-nganh-hang'));
});

Breadcrumbs::register('add_nganh_hang', function ($breadcrumbs) {
    $breadcrumbs->parent('nganh_hang');
    $breadcrumbs->push('Thêm Ngành hàng',route('add-nganh-hang'));
});

Breadcrumbs::register('view_nganh_hang', function ($breadcrumbs, $nganh_hang) {
    $breadcrumbs->parent('nganh_hang');
    $breadcrumbs->push($nganh_hang->name, route('view-nganh-hang', ['id' => $nganh_hang->id]));
});

Breadcrumbs::register('edit_nganh_hang', function ($breadcrumbs, $nganh_hang) {
    $breadcrumbs->parent('nganh_hang');
    $breadcrumbs->push($nganh_hang->name,route('edit-nganh-hang',['id'=>$nganh_hang->id]));
});

//Loại phân loại
Breadcrumbs::register('category', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Loại phân loại',route('all-category'));
});

Breadcrumbs::register('add_category', function ($breadcrumbs) {
    $breadcrumbs->parent('category');
    $breadcrumbs->push('Thêm Loại phân loại',route('add-category'));
});

Breadcrumbs::register('view_category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('category');
    $breadcrumbs->push($category->name, route('view-category', ['id' => $category->id]));
});

Breadcrumbs::register('edit_category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('category');
    $breadcrumbs->push($category->name,route('edit-category',['id'=>$category->id]));
});

//Phân loại sản phẩm
Breadcrumbs::register('category-product', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Phân loại sản phẩm',route('all-category-product'));
});

Breadcrumbs::register('add-category-product', function ($breadcrumbs) {
    $breadcrumbs->parent('category-product');
    $breadcrumbs->push('Thêm Phân loại sản phẩm',route('add-category-product'));
});

Breadcrumbs::register('view-category-product', function ($breadcrumbs, $category_product) {
    $breadcrumbs->parent('category-product');
    $breadcrumbs->push($category_product->category_product_name, route('view-category-product', ['id' => $category_product->id]));
});

Breadcrumbs::register('edit-category-product', function ($breadcrumbs, $category_product) {
    $breadcrumbs->parent('category-product');
    $breadcrumbs->push($category_product->category_product_name,route('edit-category-product',['id'=>$category_product->id]));
});

//Thương hiệu sản phẩm
Breadcrumbs::register('brand', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Thương hiệu',route('all-brand'));
});

Breadcrumbs::register('add-brand', function ($breadcrumbs) {
    $breadcrumbs->parent('brand');
    $breadcrumbs->push('Thêm Thương hiệu',route('add-brand'));
});

Breadcrumbs::register('view-brand', function ($breadcrumbs, $brand) {
    $breadcrumbs->parent('brand');
    $breadcrumbs->push($brand->brand_name, route('view-brand', ['id' => $brand->id]));
});

Breadcrumbs::register('edit-brand', function ($breadcrumbs, $brand) {
    $breadcrumbs->parent('brand');
    $breadcrumbs->push($brand->brand_name,route('edit-brand',['id'=>$brand->id]));
});

//Slider
Breadcrumbs::register('slider', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Slider',route('all-slider'));
});

Breadcrumbs::register('add-slider', function ($breadcrumbs) {
    $breadcrumbs->parent('slider');
    $breadcrumbs->push('Thêm Slider',route('add-slider'));
});

Breadcrumbs::register('view-slider', function ($breadcrumbs, $slider) {
    $breadcrumbs->parent('slider');
    $breadcrumbs->push($slider->name, route('view-slider', ['id' => $slider->id]));
});

Breadcrumbs::register('edit-slider', function ($breadcrumbs, $slider) {
    $breadcrumbs->parent('slider');
    $breadcrumbs->push($slider->name,route('edit-slider',['id'=>$slider->id]));
});

//Nhóm Sản phẩm,Sản phẩm, thư viện sản phẩm, phiên bản sản phẩm
Breadcrumbs::register('product', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Nhóm sản phẩm',route('all-product'));
});

Breadcrumbs::register('add-product', function ($breadcrumbs) {
    $breadcrumbs->parent('product');
    $breadcrumbs->push('Thêm nhóm sản phẩm',route('add-product'));
});

Breadcrumbs::register('view-product', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('product');
    $breadcrumbs->push($product->name, route('view-product', ['id' => $product->id]));
});

Breadcrumbs::register('edit-product', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('product');
    $breadcrumbs->push($product->name,route('edit-product',['id'=>$product->id]));
});

//Phiên bản sản phẩm
Breadcrumbs::register('add-product-spec', function ($breadcrumbs, $product_group) {
    $breadcrumbs->parent('view-product',$product_group);
    $breadcrumbs->push('Phiên bản sản phẩm', route('add-product-spec', ['id' => $product_group->id]));
});

//Thư viện ảnh
Breadcrumbs::register('add-gallery', function ($breadcrumbs, $product_group) {
    $breadcrumbs->parent('view-product',$product_group);
    $breadcrumbs->push('Thư viện ảnh', route('add-gallery', ['id' => $product_group->id]));
});


//Bình luận
Breadcrumbs::register('comment', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Bình luận khách hàng',route('all-comment'));
});

//Đánh giá sản phẩm
Breadcrumbs::register('rating', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Đánh giá sản phẩm',route('all-rating'));
});

//Mã giảm giá
Breadcrumbs::register('coupon', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Mã giảm giá',route('all-coupon'));
});

Breadcrumbs::register('add-coupon', function ($breadcrumbs) {
    $breadcrumbs->parent('coupon');
    $breadcrumbs->push('Thêm mã giảm giá',route('add-coupon'));
});

Breadcrumbs::register('view-coupon', function ($breadcrumbs, $coupon) {
    $breadcrumbs->parent('coupon');
    $breadcrumbs->push($coupon->name, route('view-coupon', ['id' => $coupon->id]));
});

Breadcrumbs::register('edit-coupon', function ($breadcrumbs, $coupon) {
    $breadcrumbs->parent('coupon');
    $breadcrumbs->push($coupon->name,route('edit-coupon',['id'=>$coupon->id]));
});

//Video đánh giá
Breadcrumbs::register('video', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Video đánh giá',route('all-video'));
});


//Phí vận chuyển
Breadcrumbs::register('fee-ship', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Phí vận chuyển',route('fee-ship'));
});

//Hóa đơn bán hàng
Breadcrumbs::register('customer-order', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Đơn hàng',route('all-customer-order'));
});

Breadcrumbs::register('view-customer-order', function ($breadcrumbs, $customer_order) {
    $breadcrumbs->parent('customer-order');
    $breadcrumbs->push($customer_order->id, route('view-customer-order', ['id' => $customer_order->id]));
});

//Phiếu nhập
Breadcrumbs::register('phieu-nhap', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Phiếu nhập',route('all-phieu-nhap'));
});

Breadcrumbs::register('add-phieu-nhap', function ($breadcrumbs) {
    $breadcrumbs->parent('phieu-nhap');
    $breadcrumbs->push('Thêm Phiếu nhập',route('add-phieu-nhap'));
});

Breadcrumbs::register('view-phieu-nhap', function ($breadcrumbs, $phieu_nhap) {
    $breadcrumbs->parent('phieu-nhap');
    $breadcrumbs->push($phieu_nhap->name, route('view-phieu-nhap', ['id' => $phieu_nhap->id]));
});

Breadcrumbs::register('edit-phieu-nhap', function ($breadcrumbs, $phieu_nhap) {
    $breadcrumbs->parent('phieu-nhap');
    $breadcrumbs->push($phieu_nhap->name,route('edit-phieu-nhap',['id'=>$phieu_nhap->id]));
});

//Phiếu xuất
Breadcrumbs::register('phieu-xuat', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Phiếu xuất',route('all-phieu-xuat'));
});

Breadcrumbs::register('add-phieu-xuat', function ($breadcrumbs) {
    $breadcrumbs->parent('phieu-xuat');
    $breadcrumbs->push('Thêm Phiếu xuất',route('add-phieu-xuat'));
});

Breadcrumbs::register('view-phieu-xuat', function ($breadcrumbs, $phieu_xuat) {
    $breadcrumbs->parent('phieu-xuat');
    $breadcrumbs->push($phieu_xuat->name, route('view-phieu-xuat', ['id' => $phieu_xuat->id]));
});

Breadcrumbs::register('edit-phieu-xuat', function ($breadcrumbs, $phieu_xuat) {
    $breadcrumbs->parent('phieu-xuat');
    $breadcrumbs->push($phieu_xuat->name,route('edit-phieu-xuat',['id'=>$phieu_xuat->id]));
});

//Tồn kho
Breadcrumbs::register('ton-kho', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Tồn kho',route('all-ton-kho'));
});

//Công nợ nhà cung cấp
Breadcrumbs::register('cong-no-ncc', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Công nợ nhà cung cấp',route('all-cong-no-ncc'));
});

//Thánh toán công nợ
Breadcrumbs::register('thanh-toan-cong-no', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Thanh toán công nợ',route('all-thanh-toan-cong-no'));
});

Breadcrumbs::register('add-thanh-toan-cong-no', function ($breadcrumbs) {
    $breadcrumbs->parent('thanh-toan-cong-no');
    $breadcrumbs->push('Thêm thanh toán công nợ',route('add-thanh-toan-cong-no'));
});

Breadcrumbs::register('view-thanh-toan-cong-no', function ($breadcrumbs, $thanh_toan_cong_no) {
    $breadcrumbs->parent('thanh-toan-cong-no');
    $breadcrumbs->push($thanh_toan_cong_no->id, route('view-thanh-toan-cong-no', ['id' => $thanh_toan_cong_no->id]));
});

Breadcrumbs::register('edit-thanh-toan-cong-no', function ($breadcrumbs, $thanh_toan_cong_no) {
    $breadcrumbs->parent('thanh-toan-cong-no');
    $breadcrumbs->push($thanh_toan_cong_no->id,route('edit-phieu-xuat',['id'=>$thanh_toan_cong_no->id]));
});

//Báo cáo thống kê
Breadcrumbs::register('statistic-order', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Thống kê đơn hàng, doanh số',route('statistic-order'));
});

Breadcrumbs::register('statistic-product-post', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Thống kê sản phẩm, bài viết',route('statistic-product-post'));
});

Breadcrumbs::register('statistic-xuat-nhap-ton', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Thống kê xuất nhập tồn',route('statistic-xuat-nhap-ton'));
});

//Danh mục Bài viết
Breadcrumbs::register('post-type', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Danh mục bài viết',route('all-post-type'));
});

Breadcrumbs::register('add-post-type', function ($breadcrumbs) {
    $breadcrumbs->parent('post-type');
    $breadcrumbs->push('Thêm danh mục bài viết',route('add-post-type'));
});

Breadcrumbs::register('view-post-type', function ($breadcrumbs, $post_type) {
    $breadcrumbs->parent('post-type');
    $breadcrumbs->push($post_type->name, route('view-post-type', ['id' => $post_type->id]));
});

Breadcrumbs::register('edit-post-type', function ($breadcrumbs, $post_type) {
    $breadcrumbs->parent('post-type');
    $breadcrumbs->push($post_type->name,route('edit-post-type',['id'=>$post_type->id]));
});

//Bài viết
Breadcrumbs::register('post', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Bài viết',route('all-post'));
});

Breadcrumbs::register('add-post', function ($breadcrumbs) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push('Thêm bài viết',route('add-post'));
});

Breadcrumbs::register('view-post', function ($breadcrumbs, $post) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push($post->title, route('view-post', ['id' => $post->id]));
});

Breadcrumbs::register('edit-post', function ($breadcrumbs, $post) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push($post->title, route('edit-post',['id'=>$post->id]));
});
?>
