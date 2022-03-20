<?php

namespace App\Http\Controllers;

use App\Models\DacTinh;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductSpec;
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
                   $sku .= '-'.Str::slug($data[$dac_tinh->code][$i]);
                   $attr.= '-'.$data[$dac_tinh->code][$i];
               }
           }
           $product->code=$product_group->code.$sku;
           $product->sku=$product_group->code.$sku;
           $product->name = substr($attr,1);
           $product->save();
           foreach ($dac_tinhs as $key=>$dac_tinh){
               $product_spec = new ProductSpec();
               $product_spec->name = $dac_tinh->name;
               $product_spec->value = $data[$dac_tinh->code][$i];
               $product_spec->code=Str::slug($dac_tinh->name.$data[$dac_tinh->code][$i]);
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
            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>

                                        <th>Tên</th>';

        foreach($dac_tinhs as $dac_tinh)
            $output.='<th>'.$dac_tinh->name.'</th>';

        $output.='                          <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>';

        if($products_count>0){
            $i=0;
            foreach ($products as $product){
                $i++;
                $output.='<tr>
                            <td>'.$i.'</td>

                            <td>'.$product->name.'</td>';
                foreach ($product->product_specs as $pro)
                    $output.='<td>'.$pro->value.'</td>';

                $output.='<td>
                                <button type="button" data-product_id="'.$product->id.'" class="btn btn-danger delete-gallery">Xóa</button>
                            </td>
                         </tr>
                    </form>';
            }
        }else{
            $output.='
             <tr>
                <td colspan="8">Sản phẩm chưa có phiên bản</td>
             </tr>
            ';
        }
        $output.='
             </tbody>
             </table>
            ';
        echo $output;
    }
}
