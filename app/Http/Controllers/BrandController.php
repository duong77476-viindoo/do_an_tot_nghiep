<?php

namespace App\Http\Controllers;

use App\api\API_V1;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
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
        //Paginator::useTailwind();
        $brands = Brand::paginate(5);
//        VarDumper::dump($brands);
//        exit();
        //$ds_brands = view('admin.brand.all_brand')->with('brands',$brands);
        return view('admin.brand.all_brand')->with('brands',$brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.brand.add_brand');
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
            'brand_name' => 'required|min:6|max:50',
            'brand_desc' => 'required',
            'brand_status' => 'required',
        ]);
        $brand = new Brand();
        $data = $request->all();
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_desc'];
        $brand->brand_status = $data['brand_status'];
        //$brand->brand_slug = API_V1::createCode( $data['brand_name']);
        $brand->created_at = now();
        $brand->updated_at = now();
        $brand->save();
        Session::put('message','<p class="text-success">Thêm thương hiệu thành công</p>');
        return Redirect::to('add-brand');
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
        $brand = Brand::where('id', $id)->get();;
        return view('admin.brand.view_brand')->with('brand',$brand);
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
        $brand = Brand::where('id', $id)->get();
        return view('admin.brand.edit_brand')->with('brand',$brand);
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
            'brand_name' => 'required|min:6|max:50',
            'brand_desc' => 'required',
            'brand_status' => 'required',
        ]);
        //$brand = Brand::where('id', $id);
        $data = $request->all();
        $brand = Brand::find($id);
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_desc'];
        $brand->updated_at = now();
        $brand->save();
        Session::put('message','<p class="text-success">Sửa thương hiệu thành công</p>');
        return Redirect::to('all-brand');
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
        $brand = Brand::destroy($id);
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-brand');
    }

    public function active_brand($id){
        Brand::where('id', $id)
            ->update(['brand_status' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-brand');
    }

    public function unactive_brand($id){

        Brand::where('id', $id)
            ->update(['brand_status' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-brand');
    }
}
