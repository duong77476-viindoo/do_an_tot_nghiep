<?php

namespace App\Http\Controllers;

use App\Models\CongNoNcc;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatisticCongNo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cong_no_nccs = CongNoNcc::where("trang_thai","Hoàn thành")->get();
        return view('admin.statistic.cong_no')
            ->with('cong_no_nccs',$cong_no_nccs);
    }

    public function cong_no_chart(){
        $stat_cong_no = CongNoNcc::groupBy('nha_cung_cap_id')
            ->selectRaw('nha_cung_cap_id,
            sum(cong_no_dau_thang) as sum_cong_no_dau_thang,
            sum(cong_no_cuoi_thang) as sum_cong_no_cuoi_thang,
            sum(cong_no_da_thanh_toan) as sum_cong_no_da_thanh_toan,
            sum(cong_no_con) as sum_cong_no_con')
            ->where('trang_thai','Hoàn thành')->get();
        foreach ($stat_cong_no as $stat){
            $nha_cung_cap  = NhaCungCap::find($stat->nha_cung_cap_id);
            $chart_data[] = array(
                'nha_cung_cap'=>$nha_cung_cap->name,
                'cong_no_dau_thang'=>$stat->sum_cong_no_dau_thang,
                'cong_no_cuoi_thang'=>$stat->sum_cong_no_cuoi_thang,
                'cong_no_da_thanh_toan'=>$stat->sum_cong_no_da_thanh_toan,
                'cong_no_con'=>$stat->sum_cong_no_con
            );
        }
        echo json_encode($chart_data);
    }
}
