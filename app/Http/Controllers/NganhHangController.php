<?php

namespace App\Http\Controllers;

use App\Models\DacTinh;
use App\Models\NganhHang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class NganhHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nganh_hangs = NganhHang::all();

        return view('admin.nganh_hang.index')->with('nganh_hangs',$nganh_hangs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.nganh_hang.create');
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
            'name' => 'required|min:1'
        ]);

        $nganh_hang = new NganhHang();
        $data = $request->all();
        $nganh_hang->name = $data['name'];
        $nganh_hang->created_at = now();
        $nganh_hang->updated_at = now();
        $nganh_hang->save();

        Session::put('message','<p class="text-success">Thêm ngành hàng thành công</p>');
        return \redirect()->route('view-nganh-hang',['id'=>$nganh_hang->id]);
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
        $nganh_hang = NganhHang::find($id);

//        VarDumper::dump($category_nganh_hangs_id);
//        exit();
        return view('admin.nganh_hang.view')
            ->with('nganh_hang',$nganh_hang);
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

        $nganh_hang = NganhHang::find($id);

//        VarDumper::dump($category_nganh_hangs_id);
//        exit();
        return view('admin.nganh_hang.edit')
            ->with('nganh_hang',$nganh_hang);
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
            'name' => 'required|min:1',
        ]);

        $nganh_hang = NganhHang::find($id);
        $data = $request->all();

        $nganh_hang->name = $data['name'];
        $nganh_hang->updated_at = now();

        $nganh_hang->save();

        Session::put('message','<p class="text-success">Sửa ngành hàng thành công</p>');
        return \redirect()->route('view-nganh-hang',['id'=>$nganh_hang->id]);
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
        $nganh_hang = NganhHang::find($id);
        $nganh_hang->delete();
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-nganh-hang');
    }

    public function add_dac_tinh($nganh_hang_id){
        $nganh_hang = NganhHang::find($nganh_hang_id);
        $dac_tinhs = DacTinh::where('nganh_hang_id',$nganh_hang_id)->get();
        return view('admin.dac_tinh.index')
            ->with('dac_tinhs',$dac_tinhs)
            ->with('nganh_hang',$nganh_hang);
    }

    public function save_dac_tinh(Request $request){
        $validated = $request->validate([
            'name' => 'required|min:1'
        ]);

        $dac_tinh = new DacTinh();
        $data = $request->all();
        $dac_tinh->name = $data['name'];
        $dac_tinh->nganh_hang_id = $data['nganh_hang_id'];
        $dac_tinh->created_at = now();
        $dac_tinh->updated_at = now();
        $dac_tinh->save();

        Session::put('message','<p class="text-success">Thêm đặc tính thành công</p>');
        return Redirect::to('add-dac-tinh/'.$dac_tinh->nganh_hang_id);
    }

    public function delete_dac_tinh($id){
        $dac_tinh = DacTinh::find($id);
        $dac_tinh->delete();
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::back();

    }

    public function active_nganh_hang($id){
        NganhHang::where('id', $id)
            ->update(['status' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-nganh-hang');
    }

    public function unactive_nganh_hang($id){

        NganhHang::where('id', $id)
            ->update(['status' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-nganh-hang');
    }
}
