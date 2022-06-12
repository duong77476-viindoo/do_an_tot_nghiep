<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuNhap;
use App\Models\DacTinh;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductSpec;
use App\Models\TonKho;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\VarDumper;

class ProductController extends Controller
{
   public function add_product_spec($product_group_id){
       $product_group = ProductGroup::find($product_group_id);
//       foreach ($product_group->products as $product){
//           VarDumper::dump($product->product_specs);
////           foreach ($product->product_specs as $pro){
////               VarDumper::dump($pro->value);
////           }
//       }
//       exit();
       $dac_tinhs = DacTinh::where('nganh_hang_id',$product_group->nganh_hang->id)->get();
       return view('admin.product_spec.create')
           ->with('product_group',$product_group)
           ->with('dac_tinhs',$dac_tinhs);
   }

   public function insert_product_spec(Request $request, $product_group_id){
//       $validated = $request->validate([
//           ''=>'required',
//       ]);
       $data = $request->all();
       $product_group = ProductGroup::find($product_group_id);
       $dac_tinhs = DacTinh::where('nganh_hang_id',$product_group->nganh_hang->id)->get();
       $count = count($data[$dac_tinhs[0]->code]);//Số lượng phiên bản


//       VarDumper::dump(count($data));

       for ($i=0;$i<$count;$i++){
           $sku = '';
           $attr='';
           $product = new Product();
           $product->product_group_id = $product_group_id;
           $product->created_at = now();
           $product->updated_at = now();

           foreach ($dac_tinhs as $key=>$dac_tinh){
               if($key<3){
                   $sku .= Str::slug($data[$dac_tinh->code][$i]);
                   $attr.= $data[$dac_tinh->code][$i];
                   if($key<2){
                       $sku .= '-';
                       $attr.= '-';
                   }
               }
           }
           $product->code=$product_group->code.$sku;
           $product->sku=$sku;
           $product->name =$product_group->name.$sku;
           $gia_ban_format = $this->format_currency($data['gia_ban'][$i]);
           $product->gia_ban = floatval($gia_ban_format);
           $product->save();
           //Tạo tồn kho cho sản phẩm mới
           $month = \date("m");
           $year = \date('Y');
           $ton_kho_by_product = TonKho::where('product_id',$product->id)->where('year',$year)->where('month',$month)->first();
           if(is_null($ton_kho_by_product)){
               $ton_kho_by_product = new TonKho();
               $ton_kho_by_product->year = $year;
               $ton_kho_by_product->month = $month;
               $ton_kho_by_product->ton_dau_thang = 0;
               $ton_kho_by_product->nhap_trong_thang = 0;
               $ton_kho_by_product->xuat_trong_thang = 0;
               $ton_kho_by_product->xuat_trong_thang = 0;
               $ton_kho_by_product->ton = 0;
               $ton_kho_by_product->product_id = $product->id;
           }
           $ton_kho_by_product->save();

           foreach ($dac_tinhs as $key=>$dac_tinh){
               $product_spec = new ProductSpec();
               $product_spec->name = $dac_tinh->name;
               $product_spec->value = $data[$dac_tinh->code][$i];
               $product_spec->code=Str::slug($dac_tinh->name);
               $product_spec->product_id = $product->id;
               $product_spec->created_at = now();
               $product_spec->updated_at = now();
               $product_spec->save();
           }

       }
//       foreach ($dac_tinhs as $key=>$dac_tinh){
////           VarDumper::dump($data[$dac_tinh->code]);
//           foreach ($data[$dac_tinh->code] as $val){
//               VarDumper::dump($val);
//
//           }
//       }
       Session::put('message','<p class="text-success">Thêm phiên bản sản phẩm thành công</p>');
       return \redirect()->back();
   }

    public function select_product_spec(Request $request){
        $product_group_id = $request->product_group_id;
        $product_group = ProductGroup::find($product_group_id);
//        $gallery =  Gallery::where('product_id',$product_id)->get();
//        $gallery_count = $gallery->count();
        $products = Product::where('product_group_id',$product_group_id)->get();
        $products_count = $products->count();
        $dac_tinhs = DacTinh::where('nganh_hang_id',$product_group->nganh_hang->id)->get();
        $output = '
            <table style="width: 150%" class="table table-responsive table-hover">
                                <thead>
                                    <tr>

                                        <th>STT</th>
                                        <th style="width: 20%">Tên</th>
                                        <th>Số lượng còn</th>';

        foreach($dac_tinhs as $dac_tinh)
            $output.='<th>'.$dac_tinh->name.'</th>';

        $output.='                          <th style="width: 10%">Giá bán</th><th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>';

        if($products_count>0){
            $i=1;
            foreach ($products as $product){
                $i++;
                $output.='<tr>

                            <td>'.$i.'</td>

                            <td><input type="text" class="form-control" name="product_name[]" value="'.$product->name.'"></td>
                            <td>'.$product->so_luong.'</td>';
                foreach ($product->product_specs as $pro)
                    $output.='<td><input type="text" class="form-control" name="'.$pro->code.'[]" value="'.$pro->value.'"></td>';
                $output.='<td><input min="'.$this->get_gia_goi_y($product->id).'" max="'.$this->get_gia_goi_y($product->id)*0.3.'" type="number" class="form-control" name="gia_ban[]" value="'.$product->gia_ban.'">
                        <div class="tooltip1">Giá gợi ý
                                                    <span class="tooltiptext1">'.$this->get_gia_goi_y($product->id).' đ</span>
                                                </div></td>';
                $output.='<td>
                                <button type="button" data-product_id="'.$product->id.'" class="btn btn-danger delete-product">Xóa</button>
                            </td>
                         </tr>
                    </form>
                    <input type="hidden" name="product_id[]" value="'.$product->id.'">';
            }
        }else{
            $output.='
             <tr>
                <td colspan="9">Sản phẩm chưa có phiên bản</td>
             </tr>
            ';
        }
        $output.='
             </tbody>
             </table>
            ';
        echo $output;
    }

    public function update_product_spec(Request $request){
        $data = $request->all();
        foreach ($data['product_id'] as $key=>$product_id){
            $product = Product::find($product_id);
            $product->name = $data['product_name'][$key];
            $product->gia_ban = $data['gia_ban'][$key];
            $sku = '';
            foreach ($product->product_specs as$key1=>$pro){
//                dd($pro);
//                VarDumper::dump($data[$pro->code]);
//                $product_spec = ProductSpec::where('product_id',$product_id)->where('code',$data[$pro->code])->first();
//                VarDumper::dump($product_spec);
//                VarDumper::dump($pro);
//                VarDumper::dump($data[$pro->code]);
                $product_spec = ProductSpec::find($pro->id);
                $product_spec->value = $data[$pro->code][$key];
                $product_spec->save();

                if($key1<3){
                    $sku .= '-'.Str::slug($product_spec->value);
                }
            }
            $product->code = $product->product_group->code.$sku;
            $product->sku = $product->product_group->code.$sku;
            $product->save();
        }
        return redirect()->back()->with('message','Update thành công');
    }

    public function delete_product_spec(Request $request){
        $product = Product::find($request->product_id);
        if($product){
            $product->delete();
            return response()->json(['success'=>'<span class="text-success">Xóa phiên bản sản phẩm thành công</span>']);
        }
        else{
            return response()->json(['error'=>'Lỗi khi xóa phiên bản sản phẩm']);
        }
    }

    //Lấy giá gợi ý dựa trên n kỳ nhập gần đây ứng với mỗi sản phẩm
    public function get_gia_goi_y($product_id){
        $chi_tiet_phieu_nhaps = ChiTietPhieuNhap::where('product_id',$product_id)->orderBy('created_at','DESC')->limit(5)->get();
        $tong_gia_ban = 0;
        if($chi_tiet_phieu_nhaps->count()!=0){
            foreach ($chi_tiet_phieu_nhaps as $item){
                $tong_gia_ban +=$item->gia_nhap;
            }
            return ($tong_gia_ban/$chi_tiet_phieu_nhaps->count());
        }
        return 0;
    }

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
