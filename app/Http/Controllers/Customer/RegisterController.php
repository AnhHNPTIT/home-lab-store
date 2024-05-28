<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Validator;
use Session;
use Redirect;
use Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __construct()
    {

    }

    // get form
    public function fulfill(){
        if(Session::has('phone_number')){
            $phone_number = Session::get('phone_number');
            if($phone_number){
                return view('fulfill_information', compact('phone_number'));
            }
        }
        return view('404');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required'
        ],
        [
            'required' => 'Bạn chưa nhập số điện thoại',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error'=>$validator->errors()->all()]);
        }
        $phone_number = $request->phone_number;
        Session::put('phone_number', $phone_number);

        $flag = Customer::where('phone_number', $phone_number)->first();
        if($flag){
            return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Số điện thoại này đã đăng kí.']);
        }
        // redirect provide account information
        return response()->json(['is' => 'success']);
    }

    public function createAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:50',
            'birthday' => 'required',
            'gender' => 'required',
            'phone_number'=>'min:9|max:11',
            'address' => 'required',
            'password'=> 'required|min:8|max:16|regex:/^[a-zA-Z0-9]+$/',
            're_password'=> 'required|min:8|max:16|regex:/^[a-zA-Z0-9]+$/',
        ],[
            'name.max'=>'Họ tên vượt quá 50 kí tự',
            'name.required'=>'Bạn chưa nhập tên',
            'birthday.required'=>'Bạn chưa nhập thông tin ngày sinh',
            'gender.required'=>'Bạn chưa chọn giới tính',
            'phone_number.max'=>'Số điện thoại này không hợp lệ',
            'phone_number.min'=>'Số điện thoại này không hợp lệ',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.regex' => 'Mật khẩu không đúng định dạng',
            'password.max'=>'Mật khẩu tối đa 16 kí tự',
            'password.min'=>'Mật khẩu cần ít nhất 8 kí tự',
            're_password.required'=>'Bạn chưa nhập lại mật khẩu',
            're_password.regex' => 'Mật khẩu nhập lại không đúng định dạng',
            're_password.min'=>'Mật khẩu nhập lại cần ít nhất 8 kí tự',
            're_password.max'=>'Mật khẩu nhập lại có tối đa 16 kí tự',
            'address.required' => 'Bạn chưa nhập địa chỉ',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }
        if($request->password !== $request->re_password ) {
            return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Mật khẩu không khớp']);
        }
        $data['name'] = $request->name;
        $data['birthday'] = $request->birthday;
        $data['birthday'] = \Carbon\Carbon::parse($data['birthday'])->format('Y-m-d');
        $data['gender'] = $request->gender;
        $data['phone_number'] = $request->phone_number;
        $data['address'] = $request->address;
        $data['password'] = bcrypt($request->password);
        $data['status'] = 1;

        unset($data['_token']);
        $member = Customer::Create($data);

        if($member){
            if(Auth::attempt(['phone_number'=>$request->phone_number,'password'=>$request->password], $remember = true)){
                return response()->json(['is' => 'success', 'complete'=>'Thông tin tài khoản được cập nhật thành công']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Tài khoản của bạn hiện tại chưa được hệ thống ghi nhận']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Quá trình đăng ký tài khoản thất bại!']);
    }
}
