<?php

namespace App\Http\Controllers;

use App\Models\Coupon;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
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
        $coupons = Coupon::paginate(5);

        return view('admin.coupon.index')->with('coupons',$coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.coupon.create');
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
        $data = $request->all();
        $coupon = new Coupon();
        $coupon->name = $data['name'];
        $coupon->code = $data['code'];
        $coupon->so_luong = $data['so_luong'];
        $coupon->tinh_nang = $data['tinh_nang'];
        $coupon->tien_giam = $data['tien_giam'];
        $coupon->created_at = now();
        $coupon->updated_at = now();
        $coupon->save();
        Session::put('message','<p class="text-success">Thêm mã giảm giá thành công</p>');
        return Redirect::to('add-coupon');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $coupon = coupon::where('id', $id)->get();;
        return view('admin.coupon.view')->with('coupon',$coupon);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $coupon = coupon::where('id', $id)->get();
        return view('admin.coupon.edit')->with('coupon',$coupon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->all();
        $coupon = Coupon::find($id);
        $coupon->name = $data['name'];
        $coupon->code = $data['code'];
        $coupon->so_luong = $data['so_luong'];
        $coupon->tinh_nang = $data['tinh_nang'];
        $coupon->tien_giam = $data['tien_giam'];
        $coupon->updated_at = now();
        $coupon->save();
        Session::put('message','<p class="text-success">Sửa mã giảm giá thành công</p>');
        return Redirect::to('all-coupon');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $coupon = Coupon::destroy($id);
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-coupon');
    }



    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('code',$data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                if($coupon_session==true){
                    $ton_tai = 0;
                    if($ton_tai==0){
                        $cou[] = array(
                          'code'=>$coupon->code,
                          'tinh_nang'=>$coupon->tinh_nang,
                          'tien_giam'=>$coupon->tien_giam
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                        'code'=>$coupon->code,
                        'tinh_nang'=>$coupon->tinh_nang,
                        'tien_giam'=>$coupon->tien_giam
                    );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return \redirect()->back()->with('message','Thêm mã giảm giá thành công');
            }
        }else{
            return \redirect()->back()->with('error','Mã giảm giá không hợp lệ');

        }
    }

    public function delete_coupon(){
        $coupon = Session::get('coupon');
        if($coupon==true){
            Session::forget('coupon');
            return \redirect()->back()->with('message','Xóa mã giảm giá thành công');
        }
    }
}
