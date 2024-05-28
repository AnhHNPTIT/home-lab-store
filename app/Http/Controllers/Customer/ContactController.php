<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Validator;

use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
     public function getFormContact(){
        return view('contact');
    }

    public function postFormContact(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required|max:10',
            'content' => 'required',
        ],
        [
            'name.required' => 'Bạn cần nhập tên',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.max' => 'Số điện thoại không quá 10 số',
            'content.required' => 'Bạn cần nhập nội dung',
        ]);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error'=>$validator->errors()->all()]);
        }
        $data = $request->all();
        unset($data['_token']);
        $flag = Contact::create($data);
        if($flag){
            return response()->json(['is' => 'success', 'complete'=>'Cám ơn bạn đã liên hệ với chúng tôi. Chúc bạn sức khỏe và thành công!']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Nội dung của bạn gửi đã gặp lỗi']);
    }
}