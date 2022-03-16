<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function send_mail(){
        $to_name = "BC Phone";
        $to_email = "duong77476@st.vimaru.edu.vn";
        $data = array("name"=>"Mail test","body"=>"Nội dung mail");

        Mail::send('frontend.pages.send_mail',$data,function ($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('Test gửi mail');
            $message->from($to_email,$to_name);
        });
//        return redirect('/trang-chu')->with('message','');
    }
}
