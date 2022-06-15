<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuNhap;
use App\Models\CongNoNcc;
use App\Models\NhaCungCap;
use App\Models\PhieuNhap;
use App\Models\Product;
use App\Models\ProductIdentity;
use App\Models\TonKho;
use Illuminate\Database\Eloquent\Model;
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
            'noi_dung' => 'required',
            'san_pham'=>'required',
        ]);
        $data = $request->all();

        foreach ($data['san_pham'] as $key=>$val){
            //Thêm imei cho mỗi số lượng nhập
            for ($i=0;$i<$data['so_luong_thuc_nhap'][$key];$i++){
                $so_luong_thuc_nhap_id = "so_luong_thuc_nhap" . ($key + 1);
                $name_of_imei_input =  $so_luong_thuc_nhap_id."imei".$i;
                $request->validate([
                   $name_of_imei_input=>'unique:product_identities,code'
                ]);
            }
        }

        $data = $request->all();

        $phieu_nhap = new PhieuNhap();
        $phieu_nhap->content = $data['noi_dung'];
        $phieu_nhap->nha_cung_cap_id = $data['nha_cung_cap_id'];
        $phieu_nhap->created_at = now();
        $phieu_nhap->updated_at = now();
        $phieu_nhap->nguoi_lap_id = Auth::id();
        $phieu_nhap->trang_thai = $data['trang_thai'];
        $phieu_nhap->save();
        $tong_tien = 0;
        foreach ($data['san_pham'] as $key=>$val){
            //Thêm imei cho mỗi số lượng nhập
            for ($i=0;$i<$data['so_luong_thuc_nhap'][$key];$i++){
                $so_luong_thuc_nhap_id = "so_luong_thuc_nhap" . ($key + 1);
                $name_of_imei_input =  $so_luong_thuc_nhap_id."imei".$i;
                $product_indentity = new ProductIdentity();
                $product_indentity->code = $data[$name_of_imei_input];
                $product_indentity->product_id = $val;
                $product_indentity->phieu_nhap_id = $phieu_nhap->id;
                $product_indentity->save();
            }

            //Tính tổng tiền nhập
            $thanh_tien_format = trim($data['thanh_tien'][$key],"đ");
            $tong_tien+=floatval($thanh_tien_format);
            //Tính tổng tiền nhập
            $chi_tiet_phieu_nhap = new ChiTietPhieuNhap();
            $chi_tiet_phieu_nhap->phieu_nhap_id = $phieu_nhap->id;
            $chi_tiet_phieu_nhap->product_id = $val;
            $chi_tiet_phieu_nhap->gia_nhap = floatval($this->format_currency($data['gia_nhap'][$key]));
            $chi_tiet_phieu_nhap->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
            $chi_tiet_phieu_nhap->so_luong_thuc_nhap = $data['so_luong_thuc_nhap'][$key];
            $chi_tiet_phieu_nhap->thanh_tien = floatval($thanh_tien_format);
            $chi_tiet_phieu_nhap->save();
        }
        $phieu_nhap->tong_tien = $tong_tien;


        if($phieu_nhap->trang_thai=="Xác nhận"){
            $tong_tien = 0;
            foreach ($data['san_pham'] as $key=>$val){
                //Tính tổng tiền nhập
                $thanh_tien_format = trim($data['thanh_tien'][$key],"đ");
                $tong_tien+=floatval($thanh_tien_format);

//            //Cập nhật số lượng của mỗi sản phẩm trong tbl product
                $product = Product::find($val);
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


//                $chi_tiet_phieu_nhap = new ChiTietPhieuNhap();
//                $chi_tiet_phieu_nhap->phieu_nhap_id = $phieu_nhap->id;
//                $chi_tiet_phieu_nhap->product_id = $val;
//                $chi_tiet_phieu_nhap->gia_nhap = floatval($this->format_currency($data['gia_nhap'][$key]));
//                $chi_tiet_phieu_nhap->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
//                $chi_tiet_phieu_nhap->so_luong_thuc_nhap = $data['so_luong_thuc_nhap'][$key];
//                $chi_tiet_phieu_nhap->thanh_tien = floatval($thanh_tien_format);
//                $chi_tiet_phieu_nhap->save();
            }
            $phieu_nhap->tong_tien = $tong_tien;
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
                $cong_no_ncc->cong_no_cuoi_thang = $tong_tien;
                $cong_no_ncc->cong_no_da_thanh_toan = 0;
                $cong_no_ncc->cong_no_con = 0;
                $cong_no_ncc->nha_cung_cap_id = $data['nha_cung_cap_id'];
            }else{
                $cong_no_ncc->cong_no_cuoi_thang += $tong_tien;
            }
            $cong_no_ncc->save();
            //Cộng số tiền nợ của nhà cung cấp
            $nha_cung_cap = NhaCungCap::find($data['nha_cung_cap_id']);
            $nha_cung_cap->so_tien_no += $tong_tien;
            $nha_cung_cap->save();
        }
        $phieu_nhap->save();


        return redirect()->route('view-phieu-nhap',['id'=>$phieu_nhap->id]);
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
    public function edit($id)
    {
        //
        $phieu_nhap = PhieuNhap::find($id);
        $chi_tiet_phieu_nhap = ChiTietPhieuNhap::where('phieu_nhap_id',$id)->get();
        $products = Product::all();
        $nha_cung_caps =NhaCungCap::all();
        return view('admin.phieu_nhap.edit')
            ->with('phieu_nhap',$phieu_nhap)
            ->with('chi_tiet_phieu_nhap',$chi_tiet_phieu_nhap)
            ->with('products',$products)
            ->with('nha_cung_caps',$nha_cung_caps);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nha_cung_cap_id' => 'required',
            'noi_dung' => 'required',
            'san_pham'=>'required',
        ]);


        $data = $request->all();
        $phieu_nhap = PhieuNhap::find($id);
        $phieu_nhap->content = $data['noi_dung'];
        $phieu_nhap->nha_cung_cap_id = $data['nha_cung_cap_id'];
        $phieu_nhap->created_at = now();
        $phieu_nhap->updated_at = now();
        $phieu_nhap->nguoi_lap_id = Auth::id();
        $phieu_nhap->trang_thai = $data['trang_thai'];
        $phieu_nhap->save();



        if($phieu_nhap->trang_thai=="Xác nhận"){
            $chi_tiet_phieu_nhaps = ChiTietPhieuNhap::where('phieu_nhap_id',$phieu_nhap->id)->delete();
            $tong_tien = 0;
            foreach ($data['san_pham'] as $key=>$val){
                //Thêm imei cho mỗi số lượng nhập
                $old_product_indentities = ProductIdentity::where('product_id',$val)->delete();
                for ($i=0;$i<$data['so_luong_thuc_nhap'][$key];$i++){
                    $so_luong_thuc_nhap_id = "so_luong_thuc_nhap" . ($key + 1);
                    $name_of_imei_input =  $so_luong_thuc_nhap_id."imei".$i;
                    $product_indentity = new ProductIdentity();
                    $product_indentity->code = $data[$name_of_imei_input];
                    $product_indentity->product_id = $val;
                    $product_indentity->phieu_nhap_id = $phieu_nhap->id;
                    $product_indentity->save();
                }
                //Tính tổng tiền nhập
                $thanh_tien_format = trim($data['thanh_tien'][$key],"đ");
                $tong_tien+=floatval($thanh_tien_format);

//            //Cập nhật số lượng của mỗi sản phẩm trong tbl product
                $product = Product::find($val);
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
                $chi_tiet_phieu_nhap->gia_nhap = floatval($this->format_currency($data['gia_nhap'][$key]));
                $chi_tiet_phieu_nhap->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
                $chi_tiet_phieu_nhap->so_luong_thuc_nhap = $data['so_luong_thuc_nhap'][$key];
                $chi_tiet_phieu_nhap->thanh_tien = floatval($thanh_tien_format);
                $chi_tiet_phieu_nhap->save();

            }
            $phieu_nhap->tong_tien = $tong_tien;
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
                $cong_no_ncc->cong_no_cuoi_thang = $tong_tien;
                $cong_no_ncc->cong_no_da_thanh_toan = 0;
                $cong_no_ncc->cong_no_con = 0;
                $cong_no_ncc->nha_cung_cap_id = $data['nha_cung_cap_id'];
            }else{
                $cong_no_ncc->cong_no_cuoi_thang += $tong_tien;
            }
            $cong_no_ncc->save();

            //Cộng số tiền nợ của nhà cung cấp
            $nha_cung_cap = NhaCungCap::find($data['nha_cung_cap_id']);
            $nha_cung_cap->so_tien_no += $tong_tien;
            $nha_cung_cap->save();
        }else{
            $chi_tiet_phieu_nhaps = ChiTietPhieuNhap::where('phieu_nhap_id',$phieu_nhap->id)->delete();
            $tong_tien = 0;
            foreach ($data['san_pham'] as $key=>$val){
                //Thêm imei cho mỗi số lượng nhập
                $old_product_indentities = ProductIdentity::where('product_id',$val)->delete();
                for ($i=0;$i<$data['so_luong_thuc_nhap'][$key];$i++){
                    $so_luong_thuc_nhap_id = "so_luong_thuc_nhap" . ($key + 1);
                    $name_of_imei_input =  $so_luong_thuc_nhap_id."imei".$i;
                    $product_indentity = new ProductIdentity();
                    $product_indentity->code = $data[$name_of_imei_input];
                    $product_indentity->product_id = $val;
                    $product_indentity->phieu_nhap_id = $phieu_nhap->id;
                    $product_indentity->save();
                }
                //Tính tổng tiền nhập
                $thanh_tien_format = trim($data['thanh_tien'][$key],"đ");
                $tong_tien+=floatval($thanh_tien_format);


                $chi_tiet_phieu_nhap = new ChiTietPhieuNhap();
                $chi_tiet_phieu_nhap->phieu_nhap_id = $phieu_nhap->id;
                $chi_tiet_phieu_nhap->product_id = $val;
                $chi_tiet_phieu_nhap->gia_nhap = floatval($this->format_currency($data['gia_nhap'][$key]));
                $chi_tiet_phieu_nhap->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
                $chi_tiet_phieu_nhap->so_luong_thuc_nhap = $data['so_luong_thuc_nhap'][$key];
                $chi_tiet_phieu_nhap->thanh_tien = floatval($thanh_tien_format);
                $chi_tiet_phieu_nhap->save();
            }
            $phieu_nhap->tong_tien = $tong_tien;
        }
        $phieu_nhap->save();
        return redirect()->route('view-phieu-nhap',['id'=>$phieu_nhap->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhieuNhap  $phieuNhap
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $phieu_nhap = PhieuNhap::find($id);
        if($phieu_nhap->trang_thai=="Xác nhận"){
            return redirect()->route('view-phieu-nhap',['id'=>$phieu_nhap->id])
                ->with('message','<p class="text-danger">Bạn không thể xóa phiếu nhập đã được xác nhận</p>');
        }
        else
            $phieu_nhap->delete();
        return redirect()->to('/phieu-nhap/all')->with('message','<p class="text-success">Xóa thành công</p>');
    }

    public function print_order($id){
        //$pdf = App::make('dompdf.wrapper');
        $phieu_nhap = PhieuNhap::find($id);
        $phieu_nhap->trang_thai = "Xác nhận";
        $chi_tiet_phieu_nhap = ChiTietPhieuNhap::where('phieu_nhap_id',$id)->get();
        $pdf= \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.phieu_nhap.print_order',['phieu_nhap'=>$phieu_nhap,'chi_tiet_phieu_nhap'=>$chi_tiet_phieu_nhap])
            ->setPaper('a4','landscape');
        return $pdf->download('Phieu_nhap.pdf');
//        return $pdf->stream();
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
