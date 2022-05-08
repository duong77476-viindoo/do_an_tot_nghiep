<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PostType;
use App\Models\ProductGroup;
use App\Models\Social;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
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

    public function login_customer_google(){
        config(['services.google.redirect'=>env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google')->redirect();
    }
    public function callback_customer_google()
    {
        if(Session::get('customer_id')){
            return redirect('trang-chu')->with('message', 'Đăng nhập thành công');
        }
            config(['services.google.redirect'=>env('GOOGLE_CLIENT_URL')]);
            $provider = Socialite::driver('google')->user();
            $account = Social::where('provider', 'google')->where('provider_id', $provider->getId())->where('provider_email',$provider->getEmail())->first();
            if ($account!=null) {
                $account_name = Customer::where('id', $account->customer_id)->first();
                if(is_null($account_name->avatar))
                    $account_name->avatar = $provider->getAvatar();
                $account_name->save();
                Session::put('customer_name', $account_name->name);
                Session::put('customer_id', $account_name->id);
                Session::put('customer_avatar', $account_name->avatar);

            } else {

                $customer_login = new Social([
                    'provider_id' => $provider->getId(),
                    'provider_email'=>$provider->getEmail(),
                    'provider' => 'google'
                ]);

                $orang = Customer::where('email', $provider->getEmail())->first();

                if (!$orang) {
                    $orang = Customer::create([
                        'name' => $provider->getName(),
                        'email' => $provider->getEmail(),
                        'password' => '',
                        'phone' => '',
                        'avatar'=>$provider->getAvatar()

                    ]);
                }
                $customer_login->customer()->associate($orang);
                $customer_login->save();

                $account_name = Customer::find($customer_login->customer_id);

                Session::put('customer_name', $account_name->name);
                Session::put('customer_id', $account_name->id);
                Session::put('customer_avatar', $account_name->avatar);

            }
        return redirect('trang-chu')->with('message', 'Đăng nhập thành công');
    }

    public function login_customer_facebook(){
        config(['services.facebook.redirect'=>env('FACEBOOK_CLIENT_REDIRECT')]);
        return Socialite::driver('facebook')->redirect();
    }
    public function callback_customer_facebook()
    {
        if(Session::get('customer_id')){
            return redirect('trang-chu')->with('message', 'Đăng nhập thành công');
        }
        config(['services.facebook.redirect'=>env('FACEBOOK_CLIENT_REDIRECT')]);
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')->where('provider_id', $provider->getId())->where('provider_email',$provider->getEmail())->first();
        if ($account!=null) {
            $account_name = Customer::where('id', $account->customer_id)->first();
            if(is_null($account_name->avatar))
                $account_name->avatar = $provider->getAvatar();
            $account_name->save();
            Session::put('customer_name', $account_name->name);
            Session::put('customer_id', $account_name->id);
            Session::put('customer_avatar', $account_name->avatar);

        } else {

            $customer_login = new Social([
                'provider_id' => $provider->getId(),
                'provider_email'=>$provider->getEmail(),
                'provider' => 'facebook'
            ]);

            $orang = Customer::where('email', $provider->getEmail())->first();

            if (!$orang) {
                $orang = Customer::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'password' => '',
                    'phone' => '',
                    'avatar'=>$provider->getAvatar()

                ]);
            }
            $customer_login->customer()->associate($orang);
            $customer_login->save();

            $account_name = Customer::find($customer_login->customer_id);

            Session::put('customer_name', $account_name->name);
            Session::put('customer_id', $account_name->id);
            Session::put('customer_avatar', $account_name->avatar);

        }
        return redirect('trang-chu')->with('message', 'Đăng nhập thành công');
    }

    public function download_order($id){
        //$pdf = App::make('dompdf.wrapper');
        $order = Order::find($id);
        $order_detail = OrderDetail::where('order_id',$id)->get();
        if(!is_null(Session::get('customer_id'))){
            $customer_id = Session::get('customer_id');
            if($order->customer_id !=$customer_id){
                return \redirect()->to('/trang-chu')->with('message','Bạn không có quyền thực hiện việc này');
            }
        }
        $pdf= \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.order.print_order',['order'=>$order,'order_detail'=>$order_detail])->setPaper('a4');
        return $pdf->stream();
    }

    public function purchase_history(){
        $customer_id = Session::get('customer_id');
        if(is_null($customer_id)){
            return \redirect()->to('login')->with('message','Mời bạn vui lòng đăng nhập để xem lịch sử mua hàng');
        }
        $orders = Order::where('customer_id',$customer_id)->orderby('created_at','DESC')->get();
        $meta_desc = 'Lịch sử mua hàng';
        $meta_keywords = 'Lịch sử mua hàng';
        $meta_title = 'Lịch sử mua hàng';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();
        return view('frontend.customer.purchase_history')
            ->with('orders',$orders)
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }

    public function detail_purchase_history($order_id){
        $customer_id = Session::get('customer_id');
        if(is_null($customer_id)){
            return \redirect()->to('login')->with('message','Mời bạn vui lòng đăng nhập để xem lịch sử mua hàng');
        }
        $order = Order::find($order_id);
        $order_detail = OrderDetail::where('order_id',$order->id)->get();
        $meta_desc = 'Lịch sử mua hàng';
        $meta_keywords = 'Lịch sử mua hàng';
        $meta_title = 'Lịch sử mua hàng';
        $url_canonical = '';
        $post_types = PostType::where('status',1)->get();
        return view('frontend.customer.detail_purchase_history')
            ->with('order',$order)
            ->with('order_detail',$order_detail)
            ->with('post_types',$post_types)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
    }
}
