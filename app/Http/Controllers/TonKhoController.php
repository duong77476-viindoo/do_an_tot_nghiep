<?php

namespace App\Http\Controllers;

use App\Exports\TonKhoExport;
use App\Models\TonKho;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;
use Symfony\Component\VarDumper\VarDumper;

class TonKhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ton_khos = TonKho::all();
        return view('admin.ton_kho.index')
            ->with('ton_khos',$ton_khos);
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
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function show(TonKho $tonKho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function edit(TonKho $tonKho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TonKho $tonKho)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function destroy(TonKho $tonKho)
    {
        //
    }

    public function chot_ton_kho(){
        $ton_khos = TonKho::where('trang_thai','Chưa hoàn thành')->get();
        //Lấy năm tháng tiếp theo
        $month = date("m");
        $year = date('Y');
        foreach ($ton_khos as $ton_kho){
            $ton_kho->ton = $ton_kho->nhap_trong_thang - $ton_kho->xuat_trong_thang;
            $ton_kho->trang_thai = "Hoàn thành";
            $ton_kho->save();
            $ton_kho_thang_toi = new TonKho();
            $ton_kho_thang_toi->ton_dau_thang = $ton_kho->ton;
            $ton_kho_thang_toi->year = $year;
            $ton_kho_thang_toi->month = $month;
            $ton_kho_thang_toi->nhap_trong_thang = 0;
            $ton_kho_thang_toi->xuat_trong_thang = 0;
            $ton_kho_thang_toi->ton = 0;
            $ton_kho_thang_toi->product_id = $ton_kho->product_id;
            $ton_kho_thang_toi->save();
        }
    }

    public function export_csv(Request $request){
        $data = $request->all();
        $ton_kho_export =  new TonKhoExport();
        $ton_kho_export->setYear($data['year']);
        $ton_kho_export->setMonth($data['month']);
        return \Maatwebsite\Excel\Facades\Excel::download($ton_kho_export,'BaoCaoTonKho.xlsx');
    }
}
