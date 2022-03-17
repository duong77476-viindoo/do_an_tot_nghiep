<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\PostType;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\VarDumper;

class CustomerController extends Controller
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
        $meta_desc = 'Customer';
        $meta_keywords = 'Customer';
        $meta_title = 'Customer';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();

        return view('frontend.pages.login')
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
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
        $existed_email = Customer::where('email',$data['email'])->first();
        if($existed_email){
            Session::put('message','<p class="text-danger">Đã tồn tại email</p>');
            return \redirect('login');
        }else{
            $customer = new Customer();
            $customer->name = $data['name'];
            $customer->email = $data['email'];
            $customer->password = md5($data['password']);
            $customer->phone = $data['phone'];
            $customer->address = $data['address'];

            $customer->save();

            Session::put('customer_id',$customer->id);
            Session::put('customer_name',$customer->name);
            return Redirect::to('/trang-chu');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function logout(){
        Session::flush();
        return Redirect::to('/login');
    }

    public function login_customer(Request $request){
        $validated = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $email = $request->email;
        $password = md5($request->password);
        $customer = Customer::where('email',$email)->where('password',$password)->first();
        if($customer){
            Session::put('customer_id',$customer->id);
            Session::put('customer_name',$customer->name);
            return Redirect::to('/trang-chu');
        }else{
            Session::put('message','<p style="color: red">Mật khẩu hoặc tài khoản không đúng</p>');
            return Redirect::to('/login');
        }


    }

}
