<?php

namespace App\Http\Controllers;

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
}
