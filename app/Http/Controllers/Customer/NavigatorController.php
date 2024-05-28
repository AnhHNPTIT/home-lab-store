<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Intro;
use App\Policy;
use App\Regular;
use App\Payment;
use App\Contact;
use Validator;

use Illuminate\Support\Facades\DB;

class NavigatorController extends Controller
{
     public function getFormContact(){
        return view('contact');
    }

    public function postFormContact(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:50',
            'email' => 'required|email',
            'content' => 'required',
        ],
        [
            'name.max'=>'Họ tên vượt quá 50 kí tự',
            'name.required'=>'Bạn chưa nhập tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'content.required' => 'Bạn chưa nhập nội dung',
        ]);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error'=>$validator->errors()->all()]);
        }
        $data = $request->all();
        unset($data['_token']);
        $flag = Contact::create($data);
        if($flag){
            return response()->json(['is' => 'success', 'complete'=>'Cám ơn bạn đã liên hệ với chúng tôi. Chúc bạn sức khỏe và thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Nội dung của bạn gửi đã gặp lỗi']);
    }
}
