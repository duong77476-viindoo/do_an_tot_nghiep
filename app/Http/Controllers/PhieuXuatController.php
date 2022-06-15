<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuXuat;
use App\Models\CongNoNcc;
use App\Models\NhaCungCap;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PhieuXuat;
use App\Models\Product;
use App\Models\ProductIdentity;
use App\Models\TonKho;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class PhieuXuatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $phieu_xuats = PhieuXuat::all();
        return view('admin.phieu_xuat.index')->with('phieu_xuats',$phieu_xuats);
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
        $orders = Order::where('trang_thai','Đang xử lý')->get();
        return view('admin.phieu_xuat.create')
            ->with('products',$products)
            ->with('orders',$orders);
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
            'noi_dung' => 'required',
            'san_pham'=>'required',
        ]);

        $data = $request->all();
        $order = Order::find($data['order_id']);
        $product_by_order = OrderDetail::where('order_id',$order->id)->get();

        if($product_by_order->count()!=count($data['san_pham'])){
            return redirect()->back()->with('message','<p class="text-danger">Số lượng sản phẩm xuất không khớp đơn hàng</p>');
        }
        $product_ids = array();
        foreach ($product_by_order as $key1=>$product){
            array_push($product_ids,strval($product->product_id));
        }
        foreach ($data['san_pham'] as $product_id){
            if(!in_array($product_id,$product_ids)){
                return redirect()->back()->with('message','<p class="text-danger">Sản phẩm xuất không khớp với đơn hàng, mời nhập lại</p>');
            }
        }
            $phieu_xuat = new PhieuXuat();
            $phieu_xuat->content = $data['noi_dung'];
            $phieu_xuat->order_id = $data['order_id'];
            $phieu_xuat->created_at = now();
            $phieu_xuat->updated_at = now();
            $phieu_xuat->nguoi_lap_id = Auth::id();
            $phieu_xuat->trang_thai = $data['trang_thai'];
            $phieu_xuat->save();

        foreach ($data['san_pham'] as $key=>$val){
            //Tính tổng tiền nhập
            $thanh_tien_format = trim($data['thanh_tien'][$key],"đ");
            $tong_tien+=floatval($thanh_tien_format);
            //Tính tổng tiền nhập
            $chi_tiet_phieu_xuat = new ChiTietPhieuXuat();
            $chi_tiet_phieu_xuat->phieu_xuat_id = $phieu_xuat->id;
            $chi_tiet_phieu_xuat->product_id = $val;
            $chi_tiet_phieu_xuat->gia_xuat = floatval($this->format_currency($data['gia_xuat'][$key]));
            $chi_tiet_phieu_xuat->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
            $chi_tiet_phieu_xuat->so_luong_thuc_xuat = $data['so_luong_thuc_xuat'][$key];
            $chi_tiet_phieu_xuat->thanh_tien = floatval($thanh_tien_format);
            $chi_tiet_phieu_xuat->save();
        }
        if($data['trang_thai']=="Xác nhận") {

            $tong_tien = 0;
            foreach ($data['san_pham'] as $key => $val) {
//            VarDumper::dump($val);
//            VarDumper::dump($data['so_luong_yeu_cau'][$key]);
                //Tính tổng tiền xuất
                $thanh_tien_format = trim($data['thanh_tien'][$key], "đ");
                $tong_tien += floatval($thanh_tien_format);

                //Cập nhật số lượng của mỗi sản phẩm trong tbl product
                $product = Product::find($val);
                $product->so_luong -= $data['so_luong_thuc_xuat'][$key];
                $product->save();


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
                    $ton_kho_by_product->xuat_trong_thang = $data['so_luong_thuc_xuat'][$key];
                    $ton_kho_by_product->ton = 0;
                    $ton_kho_by_product->product_id = $val;
                } else {
                    $ton_kho_by_product->xuat_trong_thang += $data['so_luong_thuc_xuat'][$key];
                }
                $ton_kho_by_product->save();


//                $chi_tiet_phieu_xuat = new ChiTietPhieuXuat();
//                $chi_tiet_phieu_xuat->phieu_xuat_id = $phieu_xuat->id;
//                $chi_tiet_phieu_xuat->product_id = $val;
//                $chi_tiet_phieu_xuat->gia_xuat = floatval($this->format_currency($data['gia_xuat'][$key]));
//                $chi_tiet_phieu_xuat->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
//                $chi_tiet_phieu_xuat->so_luong_thuc_xuat = $data['so_luong_thuc_xuat'][$key];
//                $chi_tiet_phieu_xuat->thanh_tien = floatval($thanh_tien_format);
//                $chi_tiet_phieu_xuat->save();
            }
            $phieu_xuat->tong_tien = $tong_tien;
        }
            $phieu_xuat->save();

            return redirect()->route('view-phieu-xuat', ['id' => $phieu_xuat->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phieu_xuat = PhieuXuat::find($id);
        $chi_tiet_phieu_xuat = ChiTietPhieuXuat::where('phieu_xuat_id',$id)->get();
        return view('admin.phieu_xuat.view')
            ->with('phieu_xuat',$phieu_xuat)
            ->with('chi_tiet_phieu_xuat',$chi_tiet_phieu_xuat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $phieu_xuat = PhieuXuat::find($id);
        $chi_tiet_phieu_xuat = ChiTietPhieuXuat::where('phieu_xuat_id',$id)->get();
        $products = Product::all();
        return view('admin.phieu_xuat.edit')
            ->with('phieu_xuat',$phieu_xuat)
            ->with('chi_tiet_phieu_xuat',$chi_tiet_phieu_xuat)
            ->with('products',$products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhieuXuat  $phieuXuat
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
        $phieu_xuat = PhieuXuat::find($id);
        if($phieu_xuat->trang_thai=="Xác nhận")
            return redirect()->back()->with('message','<p class="text-danger">Bạn không thể sửa một phiếu xuất đã được xác nhận</p>');
        $phieu_xuat->content = $data['noi_dung'];
        $phieu_xuat->order_id = $data['order_id'];
        $phieu_xuat->trang_thai = $data['trang_thai'];
        $phieu_xuat->updated_at = now();
        $phieu_xuat->nguoi_lap_id = Auth::id();
        $phieu_xuat->save();


        if($data['trang_thai']=="Xác nhận") {
            $chi_tiet_phieu_xuats = ChiTietPhieuXuat::where('phieu_xuat_id',$phieu_xuat->id)->delete();
            $tong_tien = 0;
            foreach ($data['san_pham'] as $key => $val) {

                //Tính tổng tiền xuất
                $thanh_tien_format = trim($data['thanh_tien'][$key], "đ");
                $tong_tien += floatval($thanh_tien_format);

                //Cập nhật số lượng của mỗi sản phẩm trong tbl product
                $product = Product::find($val);
                $product->so_luong -= $data['so_luong_thuc_xuat'][$key];
                $product->save();


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
                    $ton_kho_by_product->xuat_trong_thang = $data['so_luong_thuc_xuat'][$key];
                    $ton_kho_by_product->ton = 0;
                    $ton_kho_by_product->product_id = $val;
                } else {
                    $ton_kho_by_product->xuat_trong_thang += $data['so_luong_thuc_xuat'][$key];
                }
                $ton_kho_by_product->save();

                $chi_tiet_phieu_xuat = new ChiTietPhieuXuat();
                $chi_tiet_phieu_xuat->phieu_xuat_id = $phieu_xuat->id;
                $chi_tiet_phieu_xuat->product_id = $val;
                $chi_tiet_phieu_xuat->gia_xuat = floatval($this->format_currency($data['gia_xuat'][$key]));
                $chi_tiet_phieu_xuat->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
                $chi_tiet_phieu_xuat->so_luong_thuc_xuat = $data['so_luong_thuc_xuat'][$key];
                $chi_tiet_phieu_xuat->thanh_tien = floatval($thanh_tien_format);
                $chi_tiet_phieu_xuat->save();

                //Đặt imei cho mỗi số lượng xuất gắn cho nó phiếu xuất id là imei đó đã xuất
                for ($i=0;$i<$data['so_luong_thuc_xuat'][$key];$i++){
                    $so_luong_thuc_xuat_id = "so_luong_thuc_xuat" . ($key + 1);
                    $name_of_imei_input =  $so_luong_thuc_xuat_id."imei".$i;
                    $product_indentity = ProductIdentity::where('code',$data[$name_of_imei_input])->where('product_id',$val)->first();
                    if(is_null($product_indentity))
                        return redirect()->back()->with('message','<p class="text-danger">Mã định danh imei '.$data[$name_of_imei_input].' không khớp với bất ký sản phẩm nào</p>');
                    $product_indentity->phieu_xuat_id = $phieu_xuat->id;
                    $product_indentity->trang_thai = "Đã xuất";
                    $product_indentity->save();
                }
            }
            $phieu_xuat->tong_tien = $tong_tien;
        }else{
            $tong_tien = 0;
            foreach ($data['san_pham'] as $key => $val) {
                //Tính tổng tiền xuất
                $thanh_tien_format = trim($data['thanh_tien'][$key], "đ");
                $tong_tien += floatval($thanh_tien_format);
                $chi_tiet_phieu_xuats = ChiTietPhieuXuat::where('phieu_xuat_id',$phieu_xuat->id)->delete();

                $chi_tiet_phieu_xuat = new ChiTietPhieuXuat();
                $chi_tiet_phieu_xuat->phieu_xuat_id = $phieu_xuat->id;
                $chi_tiet_phieu_xuat->product_id = $val;
                $chi_tiet_phieu_xuat->gia_xuat = floatval($this->format_currency($data['gia_xuat'][$key]));
                $chi_tiet_phieu_xuat->so_luong_yeu_cau = $data['so_luong_yeu_cau'][$key];
                $chi_tiet_phieu_xuat->so_luong_thuc_xuat = $data['so_luong_thuc_xuat'][$key];
                $chi_tiet_phieu_xuat->thanh_tien = floatval($thanh_tien_format);
                $chi_tiet_phieu_xuat->save();
            }
            $phieu_xuat->tong_tien = $tong_tien;
        }
        $phieu_xuat->save();


        return redirect()->route('view-phieu-xuat',['id'=>$phieu_xuat->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhieuXuat  $phieuXuat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $phieu_xuat = PhieuXuat::find($id);
        if($phieu_xuat->trang_thai=="Xác nhận"){
            return redirect()->route('view-phieu-xuat',['id'=>$phieu_xuat->id])
                ->with('message','<p class="text-danger">Bạn không thể xóa phiếu xuất đã được xác nhận</p>');
        }else{
            return redirect()->route('view-phieu-xuat',['id'=>$phieu_xuat->id])
                ->with('message','<p class="text-danger">Bạn không thể xóa phiếu xuất khi mà nó có đơn hàng đang được liên kết</p>');
        }
    }

    public function print_order($id){
        //$pdf = App::make('dompdf.wrapper');
        $phieu_xuat = PhieuXuat::find($id);
        $chi_tiet_phieu_xuat = ChiTietPhieuXuat::where('phieu_xuat_id',$id)->get();
        $pdf= \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.phieu_xuat.print_order',['phieu_xuat'=>$phieu_xuat,'chi_tiet_phieu_xuat'=>$chi_tiet_phieu_xuat])
            ->setPaper('a4','landscape');
        return $pdf->download('Phieu_xuat.pdf');
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
