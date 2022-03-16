<?php


namespace App\api;


class API_V1
{
    public static function createCode($str){
        $str = trim($str);
        $coDau = array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
        ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ"
        ,"Ặ","Ẳ","Ẵ","È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ","Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ",
            "Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ");
        $khongDau = array("a","a","a","a","a","a","a","a","a","a","a","a","a","a",
            "a","a","a","e","e","e","e","e","e","e","e","e","e","e","i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","E","E","E","E","E","E","E","E","E","E","E","I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O",
            "O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D");
        $str = str_replace($coDau,$khongDau,$str);
        $str = trim(preg_replace("/\\s+/"," ", $str));
        $str =  strtolower($str);
        return str_replace(" ",'-', $str);
    }

    public static function convertDMYtoYMD($date){
        if($date=='')
            return null;
        else{
            $arr = explode('/',$date);
            if(count($arr)==1)//người dùng đang điền giá trị ngày
                return date("Y-m").'-'.$arr[0];
            else if(count($arr)==2){// điền giá trị ngày tháng
                return date("Y")."-{$arr[1]}-{$arr[0]}";
            }else{
                $arr =  array_reverse($arr);
                return implode('-',$arr);
            }
        }
    }

//    public static function isAccess($vaitros){
//        //$vaitros: [<vaitro1], <vaitro2>, <vaitro3>]
//        //['Quản lý','Bán Hàng']
//        if(Yii::$app->user->isGuest)
//            return false;
//        /** @var User $user_logged_in */
//        $user_logged_in = Yii::$app->user->identity;
//        if($user_logged_in->id==2)
//            return true;
//        //kiểm tra vai trò của người đã đăng nhập có nằm trong danh sách vaitros ko
//        return in_array($user_logged_in->vai_tro,$vaitros);
//    }
}
