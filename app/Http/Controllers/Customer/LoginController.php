<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Customer;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'=>'required',
            'password'=> 'required',
        ],[
            'phone.required'=>'Bạn chưa nhập tài khoản',
            'password.required'=>'Bạn chưa nhập mật khẩu',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'login-failed', 'error'=>$validator->errors()->all()]);
        }
        if(Auth::attempt(['phone_number'=>$request->phone,'password'=>$request->password], $remember = true))
        {
            if(Auth::user()->status != 0){
                $ck_user = Customer::find(Auth::user()->id);
                if(isset($ck_user)){
                    return response()->json(['is' => 'login-success']);
                }
                Auth::logout();
                return response()->json(['is' => 'access-faile', 'unaccess'=>'Hệ thống đang gặp sự cố. Mong quý khách hàng thông cảm!']);
            }else{
                Auth::logout();
                return response()->json(['is' => 'block', 'block'=>'Tài khoản của bạn đang bị khóa. Vui lòng liên hệ với quản trị viên để được hỗ trợ! Trân trọng!']);
            }   
        }
        return response()->json(['is' => 'incorrect', 'incorrect'=>'Thông tin đăng nhập không chính xác']);
    }
}
