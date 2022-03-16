<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Social;
use App\Rules\Captcha;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\VarDumper\VarDumper;


class AdminController extends Controller
{
    //
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        $admin_id_social = Session::get('admin_id');
        $admin_id_auth = Auth::id();
        if($admin_id_auth || $admin_id_social)
            return view('admin.dashboard');
        return view('admin.admin_login');
    }

    public function save_admin(Request $request){
        $validated = $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|numeric',
            'password'=>'required'
        ]);
        $data = $request->all();
        $existed_email = Admin::where('email',$data['email'])->first();
        if($existed_email){
            Session::put('message','<p class="text-danger">Đã tồn tại email</p>');
            return \redirect('register-admin');
        }else{
            $admin = new Admin();
            $admin->name = $data['name'];
            $admin->email = $data['email'];
            $admin->phone = $data['phone'];
            $admin->password = md5($data['password']);
            $admin->save();
            Session::put('message','<p class="text-success">Tạo mời người dùng thành công</p>');
            return \redirect('register-admin');
        }
    }

    public function edit($id){
        $admin = Admin::where('id',$id)->first();
        return view('admin.auth.edit')->with(compact('admin'));
    }

    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6',
            'new_password_confirm' => 'required',
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|numeric',
        ]);
        if (md5($request->current_password)!=Auth::user()->getAuthPassword()) {
            // The passwords matches
            Session::put('message','<p class="text-danger">Password hiện tại không khớp</p>');
            return redirect()->back();
        }

        if(strcmp($request->current_password, $request->new_password) == 0){
            // Current password and new password same
            Session::put('message','<p class="text-danger">Mật khẩu mới không được trùng với mật khẩu cũ</p>');
            return redirect()->back();
        }

        $data = $request->all();

        $admin = Admin::find($id);
        if($admin->email==$data['email']){
            $admin->name = $data['name'];
            $admin->email = $data['email'];
            $admin->phone = $data['phone'];
            $admin->password = md5($data['new_password']);
            $admin->updated_at = now();
            $admin->save();
            Session::put('message','<p class="text-success">Cập nhật người dùng thành công</p>');
            return \redirect('view-admin-users');
        }else{
            $existed_email = Admin::where('email',$data['email'])->first();
            if($existed_email){
                Session::put('message','<p class="text-danger">Đã tồn tại email</p>');
                return \redirect('register-admin');
            }
        }
    }

    public function show($id){
        $admin = Admin::where('id',$id)->first();
        return view('admin.auth.view')->with(compact('admin'));
    }

    public function destroy($id){
        Admin::destroy($id);
        Session::put('message','<p class="text-success">Xóa người dùng thành công</p>');
        return \redirect('view-admin-users');
    }

    public function assign_roles(Request $request){
        $data = $request->all();
        $admin = Admin::where('email',$data['email'])->first();
        $roles = Role::all();
        $admin->roles()->detach();//Xóa hết quyền trước khi cập nhật quyền mới
        foreach ($roles as $role){
            if(isset($data["$role->id"]))
                $admin->roles()->attach($role);
        }

        return \redirect()->back()->with('message','<p class="text-success">Phân quyền thành công</p>');
    }

    public function view_admin_users(){
        Paginator::useBootstrap();
        $admins = Admin::paginate(5);
        $roles = Role::all();
        return view('admin.auth.index')->with(compact('admins','roles'));
    }

    public function register_admin(){
        return view('admin.auth.register');
    }

    public function login_admin(Request $request){
        $validated = $request->validate([
            'email'=>'required',
            'password'=>'required',
            'g-recaptcha-response'=>new Captcha(),
        ]);
        $data = $request->all();
        if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
            return Redirect::to('/dashboard');
        }else{
            Session::put('message','<p style="color: red">Mật khẩu hoặc tài khoản không đúng auth</p>');
            return Redirect::to('/admin');
        }
    }

    public function logout_admin(){
        Auth::logout();
        return Redirect::to('/admin');
    }



    public function dashboard(){
        return view('admin.dashboard');
    }

    public function admin_dashboard(Request $request){
        $data = $request->validate([
            'email'=>'required',
            'password'=>'required',
            'g-recaptcha-response'=>new Captcha(),
        ]);
        $admin_email = $data['email'];
        $admin_password = md5($data['password']);

        $login = Admin::where('email',$admin_email)
            ->where('password',$admin_password)->first();
        if($login){
            $login_count = $login->count();
            if($login_count>0){
                Session::put('admin_name',$login->name);
                Session::put('admin_id',$login->id);
                return Redirect::to('/dashboard');
            }
        }else{
            Session::put('message','<p style="color: red">Mật khẩu hoặc tài khoản không đúng</p>');
            return Redirect::to('/admin');
        }
    }

    public function logout(){
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }

    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri
            $account_name = Admin::where('id',$account->user_id)->first();
            Session::put('admin_name',$account_name->name);
            Session::put('admin_id',$account_name->id);
        }else{

            $admin_login = new Social([
                'provider_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Admin::where('email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Admin::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'password' => '',
                    'phone' => ''

                ]);
            }
            $admin_login->admin()->associate($orang);
            $admin_login->save();

            $account_name = Admin::where('id',$admin_login->user_id)->first();

            Session::put('admin_name',$account_name->name);
            Session::put('admin_id',$account_name->id);
        }
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');

    }

    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
        $provider = Socialite::driver('google')->user();
        $account = Social::where('provider','facebook')->where('provider_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri
            $account_name = Admin::where('id',$account->user_id)->first();
            Session::put('admin_name',$account_name->name);
            Session::put('admin_id',$account_name->id);
        }else{

            $admin_login = new Social([
                'provider_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Admin::where('email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Admin::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'password' => '',
                    'phone' => ''

                ]);
            }
            $admin_login->admin()->associate($orang);
            $admin_login->save();

            $account_name = Admin::where('id',$admin_login->user_id)->first();

            Session::put('admin_name',$account_name->name);
            Session::put('admin_id',$account_name->id);
        }
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }


}
