<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\PostType;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\VarDumper;
session_start();

class CartController extends Controller
{
    //
    public function add_cart_ajax(Request $request){
        $data = $request->all();

        $session_id = substr(md5(microtime()),rand(0,26),5);//mỗi sản phẩm thêm vào có 1 session riêng
        $cart =  Session::get('cart');
        if($cart==true){
            $ton_tai = 0;//biển kiểm tra tồn tại session cart
            foreach ($cart as $key=>$val){
                if($val['product_id']==$data['cart_product_id']){
                    $ton_tai++;
                    $cart[$key]['product_qty']+=$data['cart_product_qty'];
                }
                //kiểm tra số lượng đã đặt xem có lớn hơn trong kho hay không
                if($cart[$key]['product_qty'] > $data['product_qty'])//Nếu số lượng đã đặt lớn hơn số lượng tồn
                    return response()->json(['error'=>"Lỗi"]);
                Session::put('cart',$cart);
            }
            if($ton_tai==0){
                $cart[] = array(
                    'session_id'=> $session_id,
                    'product_name'=>$data['cart_product_name'],
                    'product_id'=>$data['cart_product_id'],
                    'product_image'=>$data['cart_product_image'],
                    'product_qty'=>$data['cart_product_qty'],
                    'so_luong_ton'=>$data['product_qty'],
                    'product_price'=>$data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id'=> $session_id,
                'product_name'=>$data['cart_product_name'],
                'product_id'=>$data['cart_product_id'],
                'product_image'=>$data['cart_product_image'],
                'product_qty'=>$data['cart_product_qty'],
                'so_luong_ton'=>$data['product_qty'],
                'product_price'=>$data['cart_product_price'],
            );
            Session::put('cart',$cart);
        }

        Session::save();
    }

    public function save_cart(Request $request){

        $product_id = $request->product_id;
        $so_luong = $request->so_luong;

        $san_pham_chon = Product::find($product_id);
        $data['id'] = $san_pham_chon->id;
        $data['qty'] = $so_luong;
        $data['name'] = $san_pham_chon->name;
        $data['price'] = $san_pham_chon->gia_ban;
        $data['weight'] = '123';
        $data['options']['image'] = $san_pham_chon->anh_dai_dien;
        Cart::add($data);
        //Cart::setGlobalTax(10);set thuế cục bộ
        //Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        //Cart::destroy();
//        VarDumper::dump(Cart::content());
//        exit();
        return Redirect::to('/show-cart');
    }

    public function gio_hang(Request $request){
        $meta_desc = 'Giỏ hàng ajax';
        $meta_keywords = 'Giỏ hàng ajax';
        $meta_title = 'Giỏ hàng ajax';
        $url_canonical = $request->url();
        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();
        $post_types = PostType::where('status',1)->get();

        return view('frontend.cart.gio_hang_ajax')
            ->with('post_types',$post_types)
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function show_cart(Request $request){
        $meta_desc = 'Giỏ hàng';
        $meta_keywords = 'Giỏ hàng';
        $meta_title = 'Giỏ hàng';
        $url_canonical = $request->url();
        $category_products = CategoryProduct::where('category_product_status',1)->get();
        $brands = Brand::where('brand_status',1)->get();
        return view('frontend.cart.gio_hang')
            ->with('category_products',$category_products)
            ->with('brands',$brands)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function delete_cart_item($id){
        //Cart::update($id,0);//update lại số lượng của sản phẩm có id được truyền vào là 0
        Cart::remove($id);//cái này là xóa luôn sản phẩm có rowId là id đc truyền vào
        return Redirect::to('/show-cart');
    }

    public function delete_cart_product($session_id){// xóa sản phẩm trong giỏ hàng bằng ajax
        $cart = Session::get('cart');
        if($cart==true){
            foreach ($cart as $key=>$val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return \redirect()->back()->with('message','Xóa sản phẩm thành công');
        }else{
            return \redirect()->back()->with('message','Xóa sản phẩm thất bại');
        }
    }

    public function delete_all_cart(){
        $cart = Session::get('cart');
        if($cart==true){
            Session::forget('cart');
            Session::forget('coupon');
            return \redirect()->back()->with('message','Đã xóa hết sản phẩm thành công');
        }
    }

    public function update_cart_ajax(Request $request){//hàm update giỏ hàng dùng session ajax
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            $message = '';
            foreach ($data['cart_qty'] as $key=>$qty){
                $i=0;
                foreach ($cart as $session=>$val){
                    $i++;
                    if($val['session_id']==$key && $qty<=$cart[$session]['so_luong_ton']){
                        $cart[$session]['product_qty']=$qty;
                        $message.='<p class="text-success">'.$i.') Cập nhật số lượng '.$cart[$session]['product_name'].' thành công</p>';
                    }elseif ($val['session_id']==$key && $qty>$cart[$session]['so_luong_ton']){
                        $message.='<p class="text-danger">'.$i.') Cập nhật số lượng '.$cart[$session]['product_name'].' thất bại, do số lượng trong kho không đủ đáp ứng nhu cầu quý khách, xin quý khách thông cảm</p>';
                    }
                }
            }
            Session::put('cart',$cart);
            return \redirect()->back()->with('message',$message);
        }else{
            return \redirect()->back()->with('message','Cập nhật sản phẩm thất bại');
        }
    }

    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId;//lấy row id của sản phẩm trong giỏ hàng
        $qty = $request->quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}
