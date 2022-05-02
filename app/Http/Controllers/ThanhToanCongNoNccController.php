<?php

namespace App\Http\Controllers;

use App\Models\CongNoNcc;
use App\Models\NhaCungCap;
use App\Models\ThanhToanCongNoNcc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThanhToanCongNoNccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $thanh_toan_cong_no_ncc = ThanhToanCongNoNcc::all();
        return view('admin.thanh_toan_cong_no_ncc.index')
            ->with('thanh_toan_cong_no_ncc',$thanh_toan_cong_no_ncc);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nha_cung_caps = NhaCungCap::all();
        return view('admin.thanh_toan_cong_no_ncc.create')
            ->with('nha_cung_caps',$nha_cung_caps);
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
        $validated = $request->validate([
            'nha_cung_cap_id' => 'required',
            'noi_dung' => 'required',
            'so_tien'=>'required',
        ]);
        $data = $request->all();
        $so_tien_thanh_toan = floatval($this->format_currency($data['so_tien']));

        $thanh_toan_cong_no_ncc = new ThanhToanCongNoNcc();
        $thanh_toan_cong_no_ncc->noi_dung = $data['noi_dung'];
        $thanh_toan_cong_no_ncc->so_tien = $so_tien_thanh_toan;
        $thanh_toan_cong_no_ncc->da_thanh_toan = 0;
        $thanh_toan_cong_no_ncc->nguoi_lap_id =  Auth::id();
        $thanh_toan_cong_no_ncc->nha_cung_cap_id = $data['nha_cung_cap_id'];
        $thanh_toan_cong_no_ncc->save();

        //Trừ đi công nợ theo tháng, năm tương ứng với nhà cung cấp
        //Công nợ cũ - công nợ đã trả + công nợ mới
//        $nha_cung_cap = NhaCungCap::find($data['nha_cung_cap_id']);
//        $nha_cung_cap->so_tien_no -= $data['so_tien'];
//        $nha_cung_cap->save();

        //Cập nhật bảng công nợ ncc
        $month = \date("m");
        $year = \date('Y');
        $cong_no_ncc = CongNoNcc::where('nha_cung_cap_id',$data['nha_cung_cap_id'])
        ->where('year',$year)->where('month',$month)->first();
        if(is_null($cong_no_ncc)){
            $cong_no_ncc = new CongNoNcc();
            $cong_no_ncc->year = $year;
            $cong_no_ncc->month = $month;
            $cong_no_ncc->cong_no_dau_thang = 0;
            $cong_no_ncc->cong_no_cuoi_thang = 0;
            $cong_no_ncc->cong_no_da_thanh_toan = $so_tien_thanh_toan;
            $cong_no_ncc->cong_no_con = 0;
            $cong_no_ncc->nha_cung_cap_id = $data['nha_cung_cap_id'];
        }else{
            $cong_no_ncc->cong_no_da_thanh_toan += $so_tien_thanh_toan;
        }
        $cong_no_ncc->save();
        return redirect()->to('thanh-toan-cong-no-ncc/all');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThanhToanCongNoNcc  $thanhToanCongNoNcc
     * @return \Illuminate\Http\Response
     */
    public function show(ThanhToanCongNoNcc $thanhToanCongNoNcc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThanhToanCongNoNcc  $thanhToanCongNoNcc
     * @return \Illuminate\Http\Response
     */
    public function edit(ThanhToanCongNoNcc $thanhToanCongNoNcc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThanhToanCongNoNcc  $thanhToanCongNoNcc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThanhToanCongNoNcc $thanhToanCongNoNcc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThanhToanCongNoNcc  $thanhToanCongNoNcc
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThanhToanCongNoNcc $thanhToanCongNoNcc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $str
     */
    public function format_currency($str): string
    {
        $str = trim($str,"đ");
        for($i=0;$i<strlen($str);$i++){
            if(strpos($str, ',') !== false)
                $str = str_replace(",","",$str);
        }
        return $str;
    }
}
