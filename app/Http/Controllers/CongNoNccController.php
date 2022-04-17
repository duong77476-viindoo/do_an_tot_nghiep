<?php

namespace App\Http\Controllers;

use App\Exports\BaoCaoCongNoExport;
use App\Exports\CongNoNccExport;
use App\Models\CongNoNcc;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\TemplateProcessor;

class CongNoNccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cong_no_nccs = CongNoNcc::all();
        $nha_cung_caps = NhaCungCap::all();
        return view('admin.cong_no_ncc.index')
            ->with('cong_no_nccs',$cong_no_nccs)
            ->with('nha_cung_caps',$nha_cung_caps);
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
     * @param  \App\Models\CongNoNcc  $congNoNcc
     * @return \Illuminate\Http\Response
     */
    public function show(CongNoNcc $congNoNcc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CongNoNcc  $congNoNcc
     * @return \Illuminate\Http\Response
     */
    public function edit(CongNoNcc $congNoNcc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CongNoNcc  $congNoNcc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CongNoNcc $congNoNcc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CongNoNcc  $congNoNcc
     * @return \Illuminate\Http\Response
     */
    public function destroy(CongNoNcc $congNoNcc)
    {
        //
    }
    public function chot_cong_no(){
        $cong_no_nccs = CongNoNcc::where('trang_thai','Chưa hoàn thành')->get();
        //Lấy năm tháng tiếp theo
        $month = date("m");
        $year = date('Y');
        foreach ($cong_no_nccs as $cong_no_ncc){
            $cong_no_ncc->cong_no_con = $cong_no_ncc->cong_no_dau_thang - $cong_no_ncc->cong_no_da_thanh_toan
                + $cong_no_ncc->cong_no_cuoi_thang;
            $cong_no_ncc->trang_thai = "Hoàn thành";
            $cong_no_ncc->save();
            $cong_no_ncc_thang_toi = new CongNoNcc();
            $cong_no_ncc_thang_toi->cong_no_dau_thang = $cong_no_ncc->cong_no_con;
            $cong_no_ncc_thang_toi->year = $year;
            $cong_no_ncc_thang_toi->month = $month;
            $cong_no_ncc_thang_toi->cong_no_cuoi_thang = 0;
            $cong_no_ncc_thang_toi->cong_no_da_thanh_toan = 0;
            $cong_no_ncc_thang_toi->cong_no_con = 0;
            $cong_no_ncc_thang_toi->nha_cung_cap_id = $cong_no_ncc->nha_cung_cap_id;
            $cong_no_ncc_thang_toi->save();
        }
    }

    public function export_csv($id){
        $cong_no_ncc = CongNoNcc::find($id);
        $cong_no_export =  new CongNoNccExport();
        $cong_no_export->setNCC($cong_no_ncc->nha_cung_cap_id);
        $cong_no_export->setYear($cong_no_ncc->year);
        $cong_no_export->setMonth($cong_no_ncc->month);
        return \Maatwebsite\Excel\Facades\Excel::download($cong_no_export,'CongNoNhaCungCap.xlsx');
    }

    public function export_so_cong_no(Request $request){
        $data = $request->all();
        $cong_no_nccs = CongNoNcc::where('trang_thai','Hoàn thành')->where('year',$data['year'])->where('month',$data['month'])->get();
        if(($cong_no_nccs)->count()==0){
//            exit();
            Session::put('message','<p class="text-danger">Không tồn tại báo cáo</p>');
            return redirect()->to('cong-no-ncc/all');
        }
        $bao_cao_cong_no_export =  new BaoCaoCongNoExport();
        $bao_cao_cong_no_export->setYear($data['year']);
        $bao_cao_cong_no_export->setMonth($data['month']);
        $file_name = 'Báo cáo tổng hợp công nợ '.$data['month'].' '.$data['year'].'.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download($bao_cao_cong_no_export,$file_name);
    }


    public function export_xac_nhan_cong_no($id){
        $cong_no_ncc = CongNoNcc::find($id);
        $bien_ban_xac_nhan_cong_no = new TemplateProcessor('public/word-template/bien_ban_xac_nhan_cong_no.docx');
        $bien_ban_xac_nhan_cong_no->setValue('id',$cong_no_ncc->id);
        $bien_ban_xac_nhan_cong_no->setValue('year',$cong_no_ncc->year);
        $bien_ban_xac_nhan_cong_no->setValue('month',$cong_no_ncc->month);
        $bien_ban_xac_nhan_cong_no->setValue('cong_no_dau_thang',$cong_no_ncc->cong_no_dau_thang);
        $bien_ban_xac_nhan_cong_no->setValue('cong_no_cuoi_thang',$cong_no_ncc->cong_no_cuoi_thang);
        $bien_ban_xac_nhan_cong_no->setValue('cong_no_da_thanh_toan',$cong_no_ncc->cong_no_da_thanh_toan);
        $bien_ban_xac_nhan_cong_no->setValue('cong_no_con',$cong_no_ncc->cong_no_con);

        $file_name = 'Biên bản xác nhận công nợ_'.$cong_no_ncc->nha_cung_cap->name;
        $bien_ban_xac_nhan_cong_no->saveAs($file_name .'.docx');
        return response()->download($file_name . '.docx')->deleteFileAfterSend(true);
    }

    public function export_doi_chieu_cong_no($id){
        $cong_no_ncc = CongNoNcc::find($id);
        $bien_ban_doi_chieu_cong_no = new TemplateProcessor('public/word-template/bien_ban_doi_chieu_cong_no.docx');
        $bien_ban_doi_chieu_cong_no->setValue('id',$cong_no_ncc->id);
        $bien_ban_doi_chieu_cong_no->setValue('year',$cong_no_ncc->year);
        $bien_ban_doi_chieu_cong_no->setValue('month',$cong_no_ncc->month);
        $bien_ban_doi_chieu_cong_no->setValue('cong_no_dau_thang',$cong_no_ncc->cong_no_dau_thang);
        $bien_ban_doi_chieu_cong_no->setValue('cong_no_cuoi_thang',$cong_no_ncc->cong_no_cuoi_thang);
        $bien_ban_doi_chieu_cong_no->setValue('cong_no_da_thanh_toan',$cong_no_ncc->cong_no_da_thanh_toan);
        $bien_ban_doi_chieu_cong_no->setValue('cong_no_con',$cong_no_ncc->cong_no_con);

        $file_name =  'Biên bản đối chiếu công nợ_'.$cong_no_ncc->nha_cung_cap->name;
        $bien_ban_doi_chieu_cong_no->saveAs($file_name .'.docx');
        return response()->download($file_name . '.docx')->deleteFileAfterSend(true);
    }
}
