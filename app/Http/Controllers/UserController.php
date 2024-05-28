<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Models\Customer;
use App\Models\Admin;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer()
    {
        $customers = DB::table('customers')->orderBy('created_at', 'desc');
        return view('user.customers_list', ['customers' => $customers->paginate()]);
    }

    public function collaborator()
    {
        $admins = Admin::where('level', 0)->orderBy('created_at', 'desc');
        return view('user.collaborators_list', ['admins' => $admins->paginate()]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birthday' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'password' => 'required|min:8|max:32',
        ],

        [
            'name.required' => 'Tên nhân viên không được để trống',
            'avatar.required' => 'Ảnh nhân viên không được để trống',
            'birthday.required' => 'Ngày sinh nhân viên không được để trống',
            'gender.required' => 'Giới tính nhân viên không được để trống',
            'phone_number.required' => 'Số điện thoại nhân viên không được để trống',
            'email.required' => 'Email nhân viên không được để trống',
            'email.email' => 'Email chưa đúng định dạng',
            'address.required' => 'Địa chỉ nhân viên không được để trống',
            'password.required' => 'Yêu cầu nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiểu 8 kí tự',
            'password.max' => 'Mật khẩu tối đa 32 kí tự',
            'avatar.image' => 'Yêu cầu phải là ảnh có đuôi jpeg,png,jpg,gif',
            'avatar.mimes' => 'Yêu cầu phải là ảnh có đuôi jpeg,png,jpg,gif',
            'avatar.max' => 'Ảnh không vượt quá 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error'=>$validator->errors()->all()]);
        }else{
            $data = $request->all();
            unset($data['_token']);
            $time = time();
            if($files = $request->file('avatar')) {
                $destinationPath = 'images/admins/'; // upload path
                $time = time();
                $fileName = $time."".date('YmdHis')."".$files->hashName();
                $files->move($destinationPath, $fileName);
                $data['avatar'] = $fileName;
            }
            
            $data['birthday'] = \Carbon\Carbon::parse($data['birthday'])->format('Y-m-d H:i:s');

            $data['level'] = 0;
            $data['status'] = 1;
            $data['password'] = bcrypt($data['password']);

            $admin = Admin::create($data);

            if(isset($admin)){
                return response()->json(['is' => 'success', 'complete'=>'Một nhân viên mới đã được thêm thành công']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Một nhân viên mới chưa được thêm thành công']);
        }
    }


    public function show($id)
    {
        $customer = Customer::find($id);
        return $customer;
    }

    public function updateCustomer(Request $request, $id)
    {       
        $data = $request->all();
        unset($data['_token']);
        $customer = Customer::find($data['id']);

        if ($customer->status == 0) {
            $customer->status = 1;
        } else {
            $customer->status = 0;
        }

        $flag = $customer->save();
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Một khách hàng đã được cập nhật trạng thái thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Một khách hàng chưa được cập nhật trạng thái']);

    }

    public function destroyCustomer($id)
    {
        $customer = Customer::findOrFail($id)->delete();
        if($customer){
            return response()->json(['is' => 'success', 'complete'=>'Một khách hàng đã được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Một khách hàng chưa được xóa thành công']);
    }

    public function showCollaborator($id)
    {
        $collaborator = Admin::findOrFail($id);
        if ($collaborator) {
            return view('user.collaborator_detail', ['collaborator' => $collaborator]);
        }
    } 

    public function updateCollaborator(Request $request, $id)
    {
        $data = $request->all();
        $collaborator = Admin::find($data['id']);
        unset($data['_token']);

        if($collaborator->status == 0)
        {
            $collaborator->status = 1;
        }
        else{
            $collaborator->status = 0; 
        }

        $flag = $collaborator->save();
        if($flag){
            return response()->json(['is' => 'success', 'complete'=>'Một nhân viên đã được cập nhật thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Một nhân viên chưa được cập nhật thành công']);
    }

    public function destroyCollaborator($id)
    {
        $collaborator = Admin::findOrFail($id)->delete();
        if($collaborator){
            return response()->json(['is' => 'success', 'complete'=>'Một nhân viên đã được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Một nhân viên chưa được xóa thành công']);

    }

    public function updateInformationCollaborator(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'birthday' => 'required',
                'gender' => 'required',
                'phone_number' => 'required',
                'address' => 'required',
            ],

            [
                'name.required' => 'Tên nhân viên không được để trống',
                'birthday.required' => 'Ngày sinh nhân viên không được để trống',
                'gender.required' => 'Giới tính nhân viên không được để trống',
                'phone_number.required' => 'Số điện thoại nhân viên không được để trống',
                'address.required' => 'Địa chỉ nhân viên không được để trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();

            $flag_code = Admin::where('name', $data['name'])->where('id', '!=', $data['id'])->first();
            if ($flag_code) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Tên nhân viên ' . $data['name'] . ' đã tồn tại']);
            }

            unset($data['_token']);
            $time = time();

            if ($files = $request->file('avatar')) {
                $destinationPath = 'images/admins/'; // upload path
                $time = time();
                $fileName = $time . "" . date('YmdHis') . "" . $files->hashName();
                $files->move($destinationPath, $fileName);
                $data['avatar'] = $fileName;

                $collaborator = Admin::where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'avatar' => $data['avatar'],
                        'birthday' => \Carbon\Carbon::parse($data['birthday'])->format('Y-m-d'),
                        'gender' => $data['gender'],
                        'phone_number' => $data['phone_number'],
                        'address' => $data['address'],
                    ]);
            } else {
                $collaborator = Admin::where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'birthday' => \Carbon\Carbon::parse($data['birthday'])->format('Y-m-d'),
                        'gender' => $data['gender'],
                        'phone_number' => $data['phone_number'],
                        'address' => $data['address'],
                    ]);
            }

            if ($collaborator) {
                return response()->json(['is' => 'success', 'complete' => 'Một nhân viên đã được cập nhật thành công']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Một nhân viên chưa được cập nhật thành công']);
        }
    }
}
