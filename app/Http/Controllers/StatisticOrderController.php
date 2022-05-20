<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\StatisticOrder;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatisticOrderController extends Controller
{
    public function statistic_order(){
        return view('admin.statistic.don_hang_doanh_so');
    }

    public function statistic_product_post(){
        $product = Product::all()->count();
        $post = Post::all()->count();
        $order = Order::all()->count();
        $video = Video::all()->count();
        $customer = Customer::all()->count();
        $product_views = Product::orderBy('views','DESC')->take(20)->get();
        $post_views = Post::orderBy('views','DESC')->take(20)->get();
        return view('admin.statistic.bai_viet_san_pham')
            ->with('product',$product)
            ->with('post',$post)
            ->with('order',$order)
            ->with('video',$video)
            ->with('customer',$customer)
            ->with('product_views',$product_views)
            ->with('post_views',$post_views);
    }

    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $stat_order = StatisticOrder::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();

        foreach ($stat_order as $stat){
            $chart_data[] = array(
                'period'=>$stat->order_date,
                'order'=>$stat->total_order,
                'sales'=>$stat->sales,
                'quantity'=>$stat->quantity
            );
        }
        echo json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
        $dau_thang_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value']=='7ngay'){
            $stat_order = StatisticOrder::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();
        } else if($data['dashboard_value']=='thangtruoc'){
            $stat_order = StatisticOrder::whereBetween('order_date',[$dau_thang_truoc,$cuoi_thang_truoc])->orderBy('order_date','ASC')->get();
        } else if($data['dashboard_value']=='thangnay'){
            $stat_order = StatisticOrder::whereBetween('order_date',[$dau_thang_nay,$now])->orderBy('order_date','ASC')->get();
        } else{
            $stat_order = StatisticOrder::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }

            foreach ($stat_order as $stat){
                $chart_data[] = array(
                    'period'=>$stat->order_date,
                    'order'=>$stat->total_order,
                    'sales'=>$stat->sales,
                    'quantity'=>$stat->quantity
                );
            }
        echo json_encode($chart_data);
    }

    public function days_order(){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $stat_order = StatisticOrder::whereBetween('order_date',[$sub30days,$now])->orderBy('order_date','ASC')->get();
        foreach ($stat_order as $stat){
            $chart_data[] = array(
                'period'=>$stat->order_date,
                'order'=>$stat->total_order,
                'sales'=>$stat->sales,
                'quantity'=>$stat->quantity
            );
        }
        echo json_encode($chart_data);
    }

}
