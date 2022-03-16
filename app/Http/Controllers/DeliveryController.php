<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\fee_ship;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\VarDumper;

class DeliveryController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    }

    public function fee_ship(Request $request){
        $cities = City::orderby('id','ASC')->get();
//        $provinces = Province::orderby('id','ASC')->get();
//        $wards = Ward::orderby('id','ASC')->get();
        return view('admin.delivery.fee_ship')
            ->with(compact('cities'));
    }
    public function select_province_ward(Request $request){
        $data = $request->all();
        if($data['action']){
            $output='';
            if($data['action']=='city'){
                $provinces = Province::where('city_id',$data['id'])->orderby('id','ASC')->get();
                $output .= '<option>---Chọn---</option>';
                foreach ($provinces as $key=>$province){
                    $output .= '<option value="'.$province->id.'">'.$province->name.'</option>';
                }
            }else{
                $wards = Ward::where('province_id',$data['id'])->orderby('id','ASC')->get();
                $output.='<option>---Chọn---</option>';
                foreach ($wards as $key=>$ward){
                    $output .= '<option value="'.$ward->id.'">'.$ward->name.'</option>';
                }
            }
        }
        echo $output;
    }

    public function add_fee_ship(Request $request){
        $validator = Validator::make($request->all(), [
            'city'=>'required',
            'province'=>'required',
            'ward'=>'required',
            'fee_ship'=>'required'
        ]);

        if ($validator->passes()) {
            $data = $request->all();
            $fee_ship = new fee_ship();
            $fee_ship->city_id = $data['city'];
            $fee_ship->province_id = $data['province'];
            $fee_ship->ward_id = $data['ward'];
            $fee_ship->fee_ship = $data['fee_ship'];
            $fee_ship->save();
            return response()->json(['success'=>'Added new records.']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function load_fee_ship(){
        $fee_ships = fee_ship::orderby('id','ASC')->get();
        $output = '';
        $output .= '<div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên thành phố</th>
                                    <th>Tên quận huyện</th>
                                    <th>Tên xã phường</th>
                                    <th>Phí vận chuyển</th>
                                </tr>
                            </thead>
                            <tbody>';
        foreach ($fee_ships as $key=>$fee_ship){
            $output.='
            <tr>
                <td>'.$fee_ship->city->name.'</td>
                <td>'.$fee_ship->province->name.'</td>
                <td>'.$fee_ship->ward->name.'</td>
                <td contenteditable="true" data-fee_ship_id="'.$fee_ship->id.'" class="fee_ship_edit">'.number_format($fee_ship->fee_ship,0,",",".").' đ</td>
            </tr>';
        }

        $output.='
                            </tbody>
                        </table>
                   </div> ';
        echo $output;
    }

    public function update_fee_ship(Request $request){
        $data = $request->all();
        $fee_ship = fee_ship::find($data['fee_ship_id']);
        //$fee_val = rtrim($data['fee_ship'],'.');
        $fee_ship->fee_ship = $data['fee_ship'];
        $fee_ship->save();
    }
}
