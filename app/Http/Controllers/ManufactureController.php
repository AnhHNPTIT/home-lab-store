<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacture;
use Validator;
use History;

class ManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$manufacturers = Manufacture::all();
    	return view('manufacturer.manufacturers_list', ['manufacturers' => $manufacturers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
        ],

        [
            'name.required' => 'Tên nhà sản xuất không được để trống',
            'name.regex' => 'Tên nhà sản xuất không được chứa kí tự đặc biệt',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error'=>$validator->errors()->all()]);
        }else{
            $data = $request->all();
            unset($data['_token']);
            $data['slug'] = str_slug($data['name']);
            
            $manufacturer = Manufacture::create($data);

            if(isset($manufacturer)){
                return response()->json(['is' => 'success', 'complete'=>'Nhà sản xuất mới đã được thêm']);
            }
            else{
                return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Nhà sản xuất mới chưa đã được thêm']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$manufacturer = Manufacture::find($id);
    	return $manufacturer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
        ],

        [
            'name.required' => 'Tên nhà sản xuất không được để trống',
            'name.regex' => 'Tên nhà sản xuất không được chứa kí tự đặc biệt',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error'=>$validator->errors()->all()]);
        }else{
            $data = $request->all();
            $manufacturer = Manufacture::find($data['id']);
            unset($data['_token']);
            unset($data['id']);
            $data['slug'] = str_slug($data['name']);
            $flag = $manufacturer->update($data);
            if($flag){
                return response()->json(['is' => 'success', 'complete'=>'Thông tin nhà sản xuất đã được cập nhật']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Thông tin nhà sản xuất chưa được cập nhật']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufacturer = Manufacture::findOrFail($id)->delete();
        if($manufacturer){
            return response()->json(['is' => 'success', 'complete'=>'Thông tin nhà sản xuất đã được xóa']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete'=>'Thông tin nhà sản xuất chưa được xóa']);
        
    }
}

