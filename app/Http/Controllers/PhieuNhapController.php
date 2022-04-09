<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuNhap;
use App\Models\NhaCungCap;
use App\Models\PhieuNhap;
use App\Models\Product;
use App\Models\TonKho;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Symfony\Component\VarDumper\VarDumper;

class PhieuNhapController extends Controller
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
        $phieu_nhaps = PhieuNhap::all();
        return view('admin.phieu_nhap.index')->with('phieu_nhaps',$phieu_nhaps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = Product::all();
        $nha_cung_caps =NhaCungCap::all();
        return view('admin.phieu_nhap.create')
            ->with('products',$products)
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
            'name' => 'required|max:50',
            'noi_dung' => 'required',
            'san_pham'=>'required',
        ]);

        $data = $request->all();
        $phieu_nhap = new PhieuNhap();
        $phieu_nhap->name = $data['name'];
        $phieu_nhap->content = $data['noi_dung'];
        $phieu_nhap->nha_cung_cap_id = $data['nha_cung_cap_id'];
        $phieu_nhap->created_at = now();
        $phieu_nhap->updated_at = now();
        $phieu_nhap->nguoi_lap_id = Auth::id();
        $phieu_nhap->save();

        $tong_tien = 0;
        foreach ($data['san_pham'] as $key=>$val){
//            VarDumper::dump($val);
//            VarDumper::dump($data['so_luong_yeu_cau'][$key]);
            //Tính tổng tiền nhập
            $tong_tien+=$data['thanh_tien'][$key];

            //Cập nhật số lượng của mỗi sản phẩm trong tbl product
            $product = Product::find($val);
            //Cập nhật giá tiền sản phẩm
            $phan_tram_loi_nhuan = 10;
            $product->gia_ban =
                round(
                    ($data['gia_nhap'][$key] / (100 - $phan_tram_loi_nhuan)) * 100
                );
            $product->so_luong += $data['so_luong_thuc_nhap'][$key];
            $product->save();


            //Cộng dồn số lượng nhập của sản phẩm tương ứng vào bảng tồn kho
            //Check tồn tài tồn của sản phẩm
            $month = \date("m");
            $year = \date('Y');
            $ton_kho_by_product = TonKho::where('product_id',$val)->where('year',$year)->where('month',$month)->first();
            if(is_null($ton_kho_by_product)){
                $ton_kho_by_product = new TonKho();
                $ton_kho_by_product->year = $year;
                $ton_kho_by_product->month = $month;
                $ton_kho_by_product->ton_dau_thang = 0;
                $ton_kho_by_product->nhap_trong_thang = $data['so_luong_thuc_nhap'][$key];
                $ton_kho_by_product->xuat_trong_thang = 0;
                $ton_kho_by_product->ton = 0;
                $ton_kho_by_product->product_id = $val;
            }else{
                $ton_kho_by_product->nhap_trong_thang += $data['so_luong_thuc_nhap'][$key];
            }
            $ton_kho_by_product->save();


            $chi_tiet_phieu_nhap = new ChiTietPhieuNhap();
            $chi_tiet_phieu_nhap->phieu_nhap_id = $phieu_nhap->id;
            $chi_tiet_phieu_nhap->product_id = $val;
            $chi_tiet_phieu_nhap->gia_nhap = $data['gia_nhap'][$key];
            $chi_tiet_phieu_nhap->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
            $chi_tiet_phieu_nhap->so_luong_thuc_nhap = $data['so_luong_thuc_nhap'][$key];
            $chi_tiet_phieu_nhap->thanh_tien = $data['thanh_tien'][$key];
            $chi_tiet_phieu_nhap->save();
        }
        $phieu_nhap->tong_tien = $tong_tien;
        $phieu_nhap->save();
        //Cộng số tiền nợ của nhà cung cấp
        $nha_cung_cap = NhaCungCap::find($data['nha_cung_cap_id']);
        $nha_cung_cap->so_tien_no += $tong_tien;
        $nha_cung_cap->save();


        return redirect()->to('phieu-nhap/all');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $phieu_nhap = PhieuNhap::find($id);
        $chi_tiet_phieu_nhap = ChiTietPhieuNhap::where('phieu_nhap_id',$id)->get();
        return view('admin.phieu_nhap.view')
            ->with('phieu_nhap',$phieu_nhap)
            ->with('chi_tiet_phieu_nhap',$chi_tiet_phieu_nhap);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function edit(PhieuNhap $phieuNhap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhieuNhap $phieuNhap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuNhap $phieuNhap)
    {
        //
    }

    public function print_order($id){
        //$pdf = App::make('dompdf.wrapper');
        $phieu_nhap = PhieuNhap::find($id);
        $chi_tiet_phieu_nhap = ChiTietPhieuNhap::where('phieu_nhap_id',$id)->get();
        $pdf= \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.phieu_nhap.print_order',['phieu_nhap'=>$phieu_nhap,'chi_tiet_phieu_nhap'=>$chi_tiet_phieu_nhap])
            ->setPaper('a4','landscape');
        return $pdf->download('Phieu_nhap.pdf');
//        return $pdf->stream();
    }
}
