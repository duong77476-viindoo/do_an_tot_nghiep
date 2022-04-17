<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuXuat;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PhieuXuat;
use App\Models\Product;
use App\Models\ProductGroup;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Paginator::useBootstrap();
        $orders = Order::orderby('created_at','DESC')->paginate(5);
        return view('admin.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Order::find($id);
        $order_detail = OrderDetail::where('order_id',$id)->get();
        return view('admin.order.view')
            ->with('order',$order)
            ->with('order_detail',$order_detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function print_order($id){
        //$pdf = App::make('dompdf.wrapper');
        $order = Order::find($id);
        $order_detail = OrderDetail::where('order_id',$id)->get();
        $pdf= \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.order.print_order',['order'=>$order,'order_detail'=>$order_detail])->setPaper('a4');
        //$view = (string)View::make('admin.order.print_order');
        //echo $view;
        return $pdf->stream();
        //return view('admin.order.print_order')->with(compact('order','order_detail'));
    }

    public function update_order_status(Request $request){
        //Cập nhật trạng thái đơn hàng
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order->trang_thai = $data['order_status'];
        $order->save();
        if($data['pre_order_status']=="Đang xử lý" || $data['pre_order_status']=="Đang giao hàng" || $data['pre_order_status']=="Đã giao hàng" ){

        }
        else if($data['order_status']=="Đang xử lý" || $data['order_status']=="Đang giao hàng" || $data['order_status']=="Đã giao hàng" ){
            $phieu_xuat = new PhieuXuat();
            $phieu_xuat->name = "Phiếu xuất bán hàng";
            $phieu_xuat->content = "Phiếu xuất cho đơn hàng mã".$data['order_id'];
            $phieu_xuat->order_id = $data['order_id'];
            $phieu_xuat->created_at = now();
            $phieu_xuat->updated_at = now();
            $phieu_xuat->save();
            foreach ($data['order_product_id'] as $key=>$product_id){
                $product = Product::find($product_id);
                $chi_tiet_phieu_xuat = new ChiTietPhieuXuat();
                $chi_tiet_phieu_xuat->phieu_xuat_id = $phieu_xuat->id;
                $chi_tiet_phieu_xuat->product_id = $product_id;
                $chi_tiet_phieu_xuat->gia_xuat = $product->gia_ban;
                $chi_tiet_phieu_xuat->so_luong_yeu_cau = $data['order_product_qty'][$key];
                $chi_tiet_phieu_xuat->save();
            }

            //            foreach ($data['order_product_id'] as $key1=>$product_id){
//                $product = ProductGroup::find($product_id);
//                $so_luong_ton = $product->so_luong;
//                $so_luong_da_ban = $product->so_luong_da_ban;
//                foreach ($data['order_product_qty'] as $key2=>$product_qty){
//                    if($key1 == $key2){
//                        $product->so_luong = $so_luong_ton - $product_qty;
//                        $product->so_luong_da_ban = $so_luong_da_ban + $product_qty;
//                        $product->save();
//                        break;
//                    }
//                }
//            }
        }
        else if($data['order_status']=="Đã hủy"){

        }
    }

}
