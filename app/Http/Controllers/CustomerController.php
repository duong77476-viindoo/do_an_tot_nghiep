<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\PostType;
use App\Models\ProductGroup;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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
        $meta_desc = 'Customer';
        $meta_keywords = 'Customer';
        $meta_title = 'Customer';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();
        $customer_id = Session::get('customer_id');
        if($customer_id){
            return Redirect::to('/trang-chu');
        }
        return view('frontend.pages.login')
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
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
        Session::put('customer_name',null);
        Session::put('customer_id',null);
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

    public function request_pass(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $email_title = "Khôi phục mật khẩu BC PHONE".' '.$now;
        $customer = Customer::where('email','=',$data['email'])->first();

        if($customer){
            $count_customer = $customer->count();
            if($count_customer==0){
                return \redirect()->back()->with('error','Email chưa được đăng ký để khôi phục mật khẩu');
            }else{
                $random_token =  Str::random();
                $customer->token = $random_token;
                $customer->save();

                $to_email = $data['email'];
                $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$random_token);

                $noi_dung = array('name'=>$email_title,'body'=>$link_reset_pass,'email'=>$data['email']);

                Mail::send('frontend.pages.forget_pass_notify',['data'=>$noi_dung], function ($message) use ($email_title,$noi_dung){
                    $message->to($noi_dung['email'])->subject($email_title);
                    $message->from($noi_dung['email'],$email_title);
                });

                return \redirect()->back()->with('message','Gửi mail thành công, vui lòng vào email của bạn để reset password');
            }
        }
    }

    public function update_new_pass(){
        $meta_desc = 'Customer';
        $meta_keywords = 'Customer';
        $meta_title = 'Customer';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();
        return view('frontend.pages.update_new_pass')
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
}

    public function save_new_pass(Request $request){
        $data = $request->all();
        $random_token = Str::random();
        $customer = Customer::where('email','=',$data['email'])->where('token','=',$data['token'])->first();
        $count = $customer->count();
        if($data['new_password']==$data['confirm_password'])
            if($count>0){
                $customer->password = md5($data['new_password']);
                $customer->token = $random_token;
                $customer->save();
                return \redirect('login')->with('message','Mật khẩu đã cập nhật thành công');
            }
        else{
            return \redirect('forget-pass')->with('error','Vui lòng nhập lại email vì link đã quá hạn');
        }
    }

    public function forget_pass(){
        $this->check_condition_reset_pass();
        $meta_desc = 'Customer';
        $meta_keywords = 'Customer';
        $meta_title = 'Customer';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();
        return view('frontend.pages.forget_pass')
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function check_condition_reset_pass(){
        $customer_id = Session::get('customer_id');
        if(!is_null($customer_id)){
            return Redirect::to('trang-chu');
        }
    }
}
