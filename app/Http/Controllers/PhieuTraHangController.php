<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuTraHang;
use App\Models\PhieuTraHang;
use App\Models\Product;
use App\Models\TonKho;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhieuTraHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\PhieuTraHang  $phieuTraHang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phieu_tra_hang = PhieuTraHang::find($id);
        $chi_tiet_phieu_tra_hang = ChiTietPhieuTraHang::where('phieu_tra_hang_id',$id)->get();
        return view('admin.phieu_tra_hang.view')
            ->with('phieu_tra_hang',$phieu_tra_hang)
            ->with('chi_tiet_phieu_tra_hang',$chi_tiet_phieu_tra_hang);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhieuTraHang  $phieuTraHang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phieu_tra_hang = PhieuTraHang::find($id);
        $chi_tiet_phieu_tra_hang = ChiTietPhieuTraHang::where('phieu_tra_hang_id',$id)->get();
        $products = Product::all();
        return view('admin.phieu_tra_hang.edit')
            ->with('phieu_tra_hang',$phieu_tra_hang)
            ->with('chi_tiet_phieu_tra_hang',$chi_tiet_phieu_tra_hang)
            ->with('products',$products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhieuTraHang  $phieuTraHang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'noi_dung' => 'required',
            'san_pham'=>'required',
            'trang_thai'=>'required'
        ]);

        $data = $request->all();
        $phieu_tra_hang = PhieuTraHang::find($id);
        if($phieu_tra_hang->trang_thai=="Xác nhận")
            return redirect()->back()->with('message','<p class="text-danger">Bạn không thể sửa một phiếu xuất đã được xác nhận</p>');
        $phieu_tra_hang->content = $data['noi_dung'];
        $phieu_tra_hang->order_id = $data['order_id'];
        $phieu_tra_hang->trang_thai = $data['trang_thai'];
        $phieu_tra_hang->updated_at = now();
        $phieu_tra_hang->nguoi_lap_id = Auth::id();
        $phieu_tra_hang->save();


        if($data['trang_thai']=="Xác nhận") {
            $chi_tiet_phieu_tra_hangs = ChiTietPhieuTraHang::where('phieu_tra_hang_id',$phieu_tra_hang->id)->delete();
            $tong_tien = 0;
            foreach ($data['san_pham'] as $key => $val) {
                //Tính tổng tiền xuất
                $thanh_tien_format = trim($data['thanh_tien'][$key], "đ");
                $tong_tien += floatval($thanh_tien_format);

//                //Cập nhật số lượng của mỗi sản phẩm trong tbl product
//                $product = Product::find($val);
//                $product->so_luong += $data['so_luong_thuc_tra'][$key];
//                $product->save();


                //Cộng dồn số lượng nhập của sản phẩm tương ứng vào bảng tồn kho
                //Check tồn tài tồn của sản phẩm
                $month = \date("m");
                $year = \date('Y');
                $ton_kho_by_product = TonKho::where('product_id', $val)->where('year', $year)->where('month', $month)->first();
                if (is_null($ton_kho_by_product)) {
                    $ton_kho_by_product = new TonKho();
                    $ton_kho_by_product->year = $year;
                    $ton_kho_by_product->month = $month;
                    $ton_kho_by_product->ton_dau_thang = 0;
                    $ton_kho_by_product->nhap_trong_thang = 0;
                    $ton_kho_by_product->xuat_trong_thang = $data['so_luong_thuc_tra'][$key];
                    $ton_kho_by_product->ton = 0;
                    $ton_kho_by_product->product_id = $val;
                } else {
                    $ton_kho_by_product->xuat_trong_thang -= $data['so_luong_thuc_tra'][$key];
                }
                $ton_kho_by_product->save();


                $chi_tiet_phieu_tra_hang = new ChiTietPhieuTraHang();
                $chi_tiet_phieu_tra_hang->phieu_tra_hang_id = $phieu_tra_hang->id;
                $chi_tiet_phieu_tra_hang->product_id = $val;
                $chi_tiet_phieu_tra_hang->gia_xuat = floatval($this->format_currency($data['gia_xuat'][$key]));
                $chi_tiet_phieu_tra_hang->so_luong_trong_don_hang = $data['so_luong_trong_don_hang'][$key];
                $chi_tiet_phieu_tra_hang->so_luong_thuc_tra = $data['so_luong_thuc_tra'][$key];
                $chi_tiet_phieu_tra_hang->thanh_tien = floatval($thanh_tien_format);
                $chi_tiet_phieu_tra_hang->save();
            }
            $phieu_tra_hang->tong_tien = $tong_tien;
        }else{
            $tong_tien = 0;
            $chi_tiet_phieu_tra_hangs = ChiTietPhieuTraHang::where('phieu_tra_hang_id',$phieu_tra_hang->id)->delete();
            foreach ($data['san_pham'] as $key => $val) {
                //Tính tổng tiền xuất
                $thanh_tien_format = trim($data['thanh_tien'][$key], "đ");
                $tong_tien += floatval($thanh_tien_format);

                $chi_tiet_phieu_tra_hang = new ChiTietPhieuTraHang();
                $chi_tiet_phieu_tra_hang->phieu_tra_hang_id = $phieu_tra_hang->id;
                $chi_tiet_phieu_tra_hang->product_id = $val;
                $chi_tiet_phieu_tra_hang->gia_xuat = floatval($this->format_currency($data['gia_xuat'][$key]));
                $chi_tiet_phieu_tra_hang->so_luong_trong_don_hang = $data['so_luong_trong_don_hang'][$key];
                $chi_tiet_phieu_tra_hang->so_luong_thuc_tra = $data['so_luong_thuc_tra'][$key];
                $chi_tiet_phieu_tra_hang->thanh_tien = floatval($thanh_tien_format);
                $chi_tiet_phieu_tra_hang->save();
            }
            $phieu_tra_hang->tong_tien = $tong_tien;
        }
        $phieu_tra_hang->save();


        return redirect()->route('view-phieu-tra-hang',['id'=>$phieu_tra_hang->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhieuTraHang  $phieuTraHang
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuTraHang $phieuTraHang)
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
