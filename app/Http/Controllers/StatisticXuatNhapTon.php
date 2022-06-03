<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TonKho;
use Illuminate\Http\Request;

class StatisticXuatNhapTon extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ton_khos = TonKho::where("trang_thai","Hoàn thành")->get();
        return view('admin.statistic.xuat_nhap_ton')
            ->with('ton_khos',$ton_khos);
    }

    public function xuat_nhap_ton_chart(){
        $stat_xuat_nhap_ton = TonKho::groupBy('year','month')
            ->selectRaw('month,
            year,
            sum(nhap_trong_thang) as tong_nhap,
            sum(xuat_trong_thang) as tong_xuat,
            sum(ton) as tong_ton')
            ->where('trang_thai','Hoàn thành')->get();
        foreach ($stat_xuat_nhap_ton as $stat){
            $chart_data[] = array(
                'month_year'=>$stat->month.'-'.$stat->year,
                'tong_nhap'=>$stat->tong_nhap,
                'tong_xuat'=>$stat->tong_xuat,
                'tong_ton'=>$stat->tong_ton
            );
        }
        echo json_encode($chart_data);
    }
}
