<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        Paginator::useBootstrap();
        $nha_cung_caps = NhaCungCap::paginate(5);

        return view('admin.nha_cung_cap.index')->with('nha_cung_caps',$nha_cung_caps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.nha_cung_cap.create');
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
            'name' => 'required|min:5',
            'phone'=>'required',
            'address'=>'required',
            'so_tai_khoan'=>'required'
        ]);

        $nha_cung_cap = new NhaCungCap();
        $data = $request->all();
        $nha_cung_cap->name = $data['name'];
        $nha_cung_cap->phone = $data['phone'];
        $nha_cung_cap->address = $data['address'];
        $nha_cung_cap->so_tai_khoan = $data['so_tai_khoan'];
        $nha_cung_cap->created_at = now();
        $nha_cung_cap->updated_at = now();
        $nha_cung_cap->save();

        Session::put('message','<p class="text-success">Thêm nhà cung cấp thành công</p>');
        return Redirect::to('add-nha-cung-cap');
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
        $nha_cung_caps = NhaCungCap::where('id', $id)->get();

//        VarDumper::dump($category_nha_cung_caps_id);
//        exit();
        return view('admin.nha_cung_cap.view')
            ->with('nha_cung_caps',$nha_cung_caps);
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

        $nha_cung_caps = NhaCungCap::where('id', $id)->get();

//        VarDumper::dump($category_nha_cung_caps_id);
//        exit();
        return view('admin.nha_cung_cap.edit')
            ->with('nha_cung_caps',$nha_cung_caps);
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
            'name' => 'required|min:5',
            'phone'=>'required',
            'address'=>'required',
            'so_tai_khoan'=>'required'
        ]);

        $nha_cung_cap = NhaCungCap::find($id);
        $data = $request->all();

        $nha_cung_cap->name = $data['name'];
        $nha_cung_cap->phone = $data['phone'];
        $nha_cung_cap->address = $data['address'];
        $nha_cung_cap->so_tai_khoan = $data['so_tai_khoan'];
        $nha_cung_cap->updated_at = now();

        $nha_cung_cap->save();

        Session::put('message','<p class="text-success">Sửa nhà cung cấp thành công</p>');
        return Redirect::to('all-nha-cung-cap');
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
        $nha_cung_cap = NhaCungCap::find($id);
        $nha_cung_cap->delete();
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-nha-cung-cap');
    }
}
