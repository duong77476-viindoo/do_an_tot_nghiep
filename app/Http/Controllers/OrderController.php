<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuNhap;
use App\Models\ChiTietPhieuXuat;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PhieuXuat;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\StatisticOrder;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Symfony\Component\VarDumper\VarDumper;

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
        $orders = Order::orderby('created_at','DESC')->get();
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
//        if($data['pre_order_status']=="Đang xử lý" || $data['pre_order_status']=="Đang giao hàng" || $data['pre_order_status']=="Đã giao hàng" ){
//
//        }
        if($data['order_status']=="Đang xử lý"){
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
            $title = "Đơn hàng "."#".$order->id." đang được xử lý";
            $this->send_mail_customer($order->id,$title);
        }else if($data['order_status']=="Đang giao hàng"){
            $title = "Đơn hàng "."#".$order->id." đang được giao hàng";
            $this->send_mail_customer($order->id,$title);
        }else if($data['order_status']=="Đã giao hàng"){
            //Đã giao hàng xong thì update vào bảng statistic order
            //Cập nhật số lượng mua, số, tổng số đơn hàng, doanh thu, lợi nhuận

            //Tính lợi nhuận
            $order_details = OrderDetail::where('order_id',$data['order_id'])->get();
            $profit = 0;
            $sales = 0;
            $chi_phi = 0;
//            dd($order_details);
            foreach ($order_details as $order_detail){
                $now = Carbon::now();
                $product = Product::find($order_detail->product_id);
                $chi_tiet_phieu_nhaps = ChiTietPhieuNhap::where('product_id',$product->id)->whereDate('created_at','<=',$now->toDate())->whereDate('created_at','>=',$now->firstOfMonth()->toDate())->get();
//                var_dump($chi_tiet_phieu_nhaps);
//                var_dump($chi_tiet_phieu_nhaps);
                $so_luong_nhap = 0;
                $tong_tien_nhap = 0;
                foreach ($chi_tiet_phieu_nhaps as $chi_tiet_phieu_nhap){
                    $so_luong_nhap += $chi_tiet_phieu_nhap->so_luong_thuc_nhap;
                    $tong_tien_nhap += $chi_tiet_phieu_nhap->thanh_tien;

                }
//                var_dump($so_luong_nhap);
//                if($so_luong_nhap==0){
//                    $so_luong_nhap = 1;
//                }

                $chi_phi = ($tong_tien_nhap / $so_luong_nhap) * $order_detail->so_luong;
//                dd($chi_phi);
                $sales = $product->gia_ban * $order_detail->so_luong;
                $profit += $sales - $chi_phi;
            }
//            dd($sales);

            $order_date = $order->order_date;
            $stat_order = StatisticOrder::where('order_date',$order_date)->first();
            if(is_null($stat_order)){
                $stat_order = new StatisticOrder();
                $stat_order->order_date = $order_date;
                $stat_order->sales = $order->tong_tien;
                $stat_order->profit = $profit + $order->fee_ship;
                $stat_order->quantity = $order->tong_so_luong;
                $stat_order->total_order = 1;
            }else{
                $stat_order->sales += $order->tong_tien;
                $stat_order->profit += $profit + $order->fee_ship;
                $stat_order->quantity += $order->tong_so_luong;
                $stat_order->total_order += 1;
            }
            $stat_order->save();
            $title = "Đơn hàng "."#".$order->id." đã giao thành công";
            $this->send_mail_customer($order->id,$title);
        }
        else if($data['order_status']=="Đã hủy"){
            $title = "Đơn hàng "."#".$order->id." đã hủy";
            $this->send_mail_customer($order->id,$title);
        }
    }

    public function send_mail_customer($order_id,$title){
        $order = Order::find($order_id);
        $order_detail = OrderDetail::where('order_id',$order_id)->get();
        Mail::send('frontend.checkout.mail_confirm_order',['title'=>$title,'order'=>$order,'order_detail'=>$order_detail],
            function ($message) use($order,$title){
                $message->to($order->customer->email)->subject($title);
                $message->from(env('MAIL_USERNAME'),$title);
            });
    }

}
