<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Pagination\Paginator;


use App\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel;
use Symfony\Component\Console\Helper\Dumper;
use Symfony\Component\VarDumper\VarDumper;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_products = CategoryProduct::all();
        return view('admin.category_product.all_category_product')->with('category_products',$category_products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('admin.category_product.add_category_product')->with(compact('categories'));
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
            'category_product_name' => 'required|min:1|max:50',
            'category_product_desc' => 'required',
            'category_product_status' => 'required',
            'meta_keywords'=>'required',
            'category_id'=>'required',
        ]);
        $category_product = new CategoryProduct();
        $data = $request->all();
        $category_product->category_product_name = $data['category_product_name'];
        $category_product->category_product_desc = $data['category_product_desc'];
        $category_product->category_product_status = $data['category_product_status'];
        $category_product->meta_keywords = $data['meta_keywords'];
        $category_product->category_id = $data['category_id'];
        $category_product->created_at = now();
        $category_product->updated_at = now();
        $category_product->save();
        Session::put('message','<p class="text-success">Thêm phân loại sản phẩm thành công</p>');
        return \redirect()->route('view-category-product',['id'=>$category_product->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $categories = Category::all();
        $category_product = CategoryProduct::where('id', $id)->get();;
        return view('admin.category_product.view_category_product')->
        with('category_product',$category_product)
            ->with(compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categories = Category::all();
        $category_product = CategoryProduct::where('id', $id)->get();
        return view('admin.category_product.edit_category_product')
            ->with('category_product',$category_product)
            ->with(compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'category_product_name' => 'required|min:1|max:50',
            'category_product_desc' => 'required',
            'meta_keywords'=>'required',
            'category_id'=>'required',
        ]);
        //$category_product = CategoryProduct::where('id', $id);
        $data = $request->all();

        CategoryProduct::where('id', $id)
            ->update
            ([
                'category_product_name'=> $data['category_product_name'],
                'category_product_desc'=> $data['category_product_desc'],
                'meta_keywords' => $data['meta_keywords'],
                'updated_at' => now()
            ]);
        Session::put('message','<p class="text-success" ">Sửa phân loại sản phẩm thành công</p>');
        return \redirect()->route('view-category-product',['id'=>$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category_product = CategoryProduct::destroy($id);
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-category-product');
    }

    public function active_category_product($id){
        CategoryProduct::where('id', $id)
            ->update(['category_product_status' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-category-product');
    }

    public function unactive_category_product($id){

        CategoryProduct::where('id', $id)
            ->update(['category_product_status' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-category-product');
    }

    public function export_csv(){
        return \Maatwebsite\Excel\Facades\Excel::download(new CategoryExport(),'danhmucsanpham.xlsx');
    }

    public function import_csv(Request $request){
        $request->validate([
            'file'=>'required',
        ]);
        $path = $request->file('file')->getRealPath();
        \Maatwebsite\Excel\Facades\Excel::import(new CategoryImport(), $path);
        return back();
    }
}
