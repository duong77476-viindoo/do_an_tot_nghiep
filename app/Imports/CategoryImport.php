<?php

namespace App\Imports;

use App\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
//        $category_product = new CategoryProduct();
//        $category_product->category_product_name = $row[0];
//        $category_product->category_product_desc = $row[1];
//        $category_product->category_product_status = $row[2];
//        $category_product->meta_keywords = $row[3];
//        $category_product->created_at = now();
//        $category_product->updated_at = now();
//        $category_product->save();
        return new CategoryProduct([
            //
            'category_product_name'=> $row['name'],
            'category_product_desc'=> $row['desc'],
            'category_product_status' => $row['status'],
            'meta_keywords' => $row['meta'],
        ]);
    }
}
