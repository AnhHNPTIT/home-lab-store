<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Validator;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();
        return view('unit.units_list', ['units' => $units]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
            ],

            [
                'name.required' => 'Tên đơn vị tính không được để trống',
                'name.regex' => 'Tên đơn vị tính không được chứa kí tự đặc biệt',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();
            unset($data['_token']);
            $data['slug'] = str_slug($data['name']);

            $unit = Unit::create($data);

            if (isset($unit)) {
                return response()->json(['is' => 'success', 'complete' => 'Đơn vị tính mới đã được thêm']);
            } else {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Đơn vị tính mới chưa đã được thêm']);
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
        $unit = Unit::find($id);
        return $unit;
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
            ],

            [
                'name.required' => 'Tên đơn vị tính không được để trống',
                'name.regex' => 'Tên đơn vị tính không được chứa kí tự đặc biệt',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();
            $unit = Unit::find($data['id']);
            unset($data['_token']);
            unset($data['id']);
            $data['slug'] = str_slug($data['name']);
            $flag = $unit->update($data);
            if ($flag) {
                return response()->json(['is' => 'success', 'complete' => 'Đơn vị tính được cập nhật thành công']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Đơn vị tính chưa được cập nhật']);
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
        $unit = Unit::findOrFail($id)->delete();
        if ($unit) {
            return response()->json(['is' => 'success', 'complete' => 'Đơn vị tính được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Đơn vị tính chưa được xóa']);
    }
}
