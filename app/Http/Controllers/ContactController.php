<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Contact;
use Validator;

class ContactController extends Controller
{
    // Lấy danh sách liên hệ
    public function index()
    {
        $contacts = Contact::all();
        return view('contact.contacts_list', ['contacts' => $contacts]);
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->all();
        unset($data['_token']);
        $contact = Contact::find($data['id']);

        if ($contact->status == 0) {
            $contact->status = 1;
        } else {
            $contact->status = 0;
        }

        $flag = $contact->save();
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Một liên hệ đã được cập nhật trạng thái thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Một liên hệ chưa được cập nhật trạng thái']);
    }    
}
