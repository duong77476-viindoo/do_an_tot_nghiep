<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\City;
use App\Models\fee_ship;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\PostType;
use App\Models\Province;
use App\Models\shipping;
use App\Models\ProductGroup;
use App\Models\Ward;
use Decimal\Decimal;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\VarDumper;

class CheckoutController extends Controller
{
    //
    public function login_checkout(){
        $meta_desc = 'Check out';
        $meta_keywords = 'Check out';
        $meta_title = 'Check out';
        $post_types = PostType::where('status',1)->get();

        $url_canonical = '';
        return view('frontend.checkout.login_checkout')
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }


    public function checkout(){
        $meta_desc = 'Check out';
        $meta_keywords = 'Check out';
        $meta_title = 'Check out';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();
        $cities = City::orderby('id','ASC')->get();
        return view('frontend.checkout.checkout')
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical)
            ->with('cities',$cities);
    }

    public function save_checkout(Request $request){
        $shipping = new Shipping();
        $data = $request->all();
        $shipping->name = $data['name'];//tên khách hàng dc ship
        $shipping->email = $data['email'];
        $shipping->phone = $data['phone'];
        $shipping->address = $data['address'];
        $shipping->ghi_chu = $data['ghi_chu'];
        $shipping->save();

        Session::put('shipping_id',$shipping->id);
        return Redirect::to('/payment');
    }
    public function payment(){
        $meta_desc = 'Payment';
        $meta_keywords = 'Payment';
        $meta_title = 'Payment';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();

        return view('frontend.checkout.payment')
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function customer_order(Request $request){
        //lấy hình thức thanh toán
        //echo (Cart::total());
//        $number = "2.432.100,00";
//        echo doubleval(Cart::total(2,',','.'));
//        echo '<br>';
//        echo Cart::total(2,'.',',');
//        echo '<br>';
        //echo Cart::totalFloat();
        //echo number_format((float)$number, 2, ',', '.');;
        //exit();
        $meta_desc = 'Payment';
        $meta_keywords = 'Payment';
        $meta_title = 'Payment';
        $url_canonical = '';
        $data = $request->all();
        $payment = new Payment();
        $payment->method = $data['payment_method'];
        $payment->status = 'Đang chờ xử lý';

        $payment->save();
        //Thêm vào bảng order
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = Session::get('shipping_id');
        $order->payment_id = $payment->id;
        $order->tong_tien =  Cart::totalFloat();
        $order->trang_thai = 'Đang chờ xử lý';
        $order->save();

        //Thêm vào order detail
        foreach (Cart::content() as $product){
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $product->id;
            $order_detail->product_name = $product->name;
            $order_detail->product_price = $product->price;
            $order_detail->so_luong = $product->qty;
            $order_detail->save();
        }
        if($data['payment_method']=="tien_mat"){
            Cart::destroy();
            return view('frontend.checkout.checkout_by_cash')
                ->with('meta_desc',$meta_desc)
                ->with('meta_keywords',$meta_keywords)
                ->with('meta_title',$meta_title)
                ->with('url_canonical',$url_canonical);
        }else if($data['payment_method'=="tin_dung"]){
            echo 'Thẻ tín dụng';
        }else{
            echo 'Thẻ ghi nợ';
        }
    }

    public function select_province_ward_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output='';
            if($data['action']=='city'){
                $provinces = Province::where('city_id',$data['id'])->orderby('id','ASC')->get();
                $output .= '<option>---Chọn---</option>';
                foreach ($provinces as $key=>$province){
                    $output .= '<option value="'.$province->id.'">'.$province->name.'</option>';
                }
            }else{
                $wards = Ward::where('province_id',$data['id'])->orderby('id','ASC')->get();
                $output.='<option>---Chọn---</option>';
                foreach ($wards as $key=>$ward){
                    $output .= '<option value="'.$ward->id.'">'.$ward->name.'</option>';
                }
            }
        }
        echo $output;
    }

    public function calculate_fee_ship(Request $request){
        $data = $request->all();
        if($data['city']){
            $fee_ship = fee_ship::where('city_id',$data['city'])
                ->where('province_id',$data['province'])
                ->where('ward_id',$data['ward'])->get();
            if($fee_ship->count()>0){
                foreach ($fee_ship as $key=>$fee){
                    Session::put('fee',$fee->fee_ship);
                    Session::save();
                }
            }else{
                $fee_default = 20000;
                Session::put('fee',$fee_default);
                Session::save();
            }

        }
    }

    public function delete_fee(){
        Session::forget('fee');
        return \redirect()->back();
    }

    public function confirm_order(Request $request){
        $data = $request->all();

        $shipping = new Shipping();
        $shipping->name = $data['name'];//tên khách hàng dc ship
        $shipping->email = $data['email'];
        $shipping->phone = $data['phone'];
        $shipping->address = $data['address'];
        $shipping->ghi_chu = $data['note'];
        $shipping->save();

        //Thêm thanh toán của khách hàng
        $payment = new Payment();
        $payment->method = $data['payment_type'];
        $payment->status = 'Đang chờ xử lý';

        $payment->save();

        //Thêm đơn hàng
        //Thêm vào bảng order
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping->id;
        $order->payment_id = $payment->id;
        $order->fee_ship = $data['fee_ship'];

        $tong_tien = 0;
        $tien_duoc_giam = 0;
        $phi_van_chuyen = $data['fee_ship'];
        foreach (Session::get('cart') as $key=>$cart){
            $subtotal = $cart['product_price'] * $cart['product_qty'];
            $tong_tien += $subtotal;
        }
        if(Session::get('coupon')){
            foreach (Session::get('coupon') as $key=>$coupon){
                if($coupon['tinh_nang']==1){
                    $tien_duoc_giam = ($tong_tien*$coupon['tien_giam'])/100;
                }else{
                    $tien_duoc_giam = $coupon['tien_giam'];
                }
            }
        }else{
            $tien_duoc_giam = 0;
        }
        $order->coupon = $tien_duoc_giam;
        $order->tong_tien =  $tong_tien-$tien_duoc_giam+$phi_van_chuyen;
        $order->trang_thai = 'Đang chờ xử lý';
        //Thêm order date
        $order_date =  Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->order_date = $order_date;
        $order->save();

        //Thêm đơn hàng chi tiết
        $tong_so_luong = 0;
        foreach (Session::get('cart') as $key=>$cart){
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $cart['product_id'];
            $order_detail->product_name = $cart['product_name'];
            $order_detail->product_price = $cart['product_price'];
            $order_detail->so_luong = $cart['product_qty'];
            $tong_so_luong += $cart['product_qty'];
            $order_detail->save();
        }
        $order->tong_so_luong = $tong_so_luong;
        $order->save();
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
        Session::save();
    }
}
