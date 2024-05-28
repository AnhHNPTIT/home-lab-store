<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tag.tags_list', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'name' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
            ],

            [
                'name.required' => 'Tên thẻ không được để trống',
                'name.max' => 'Tên thẻ không được quá :max kí tự',
                'name.regex' => 'Tên thẻ không được chứa kí tự đặc biệt',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();
            unset($data['_token']);
            $data['slug'] = str_slug($data['name']);

            $tag = Tag::create($data);

            if (isset($tag)) {
                return response()->json(['is' => 'success', 'complete' => 'Thẻ được thêm thành công']);
            } else {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Thẻ chưa được thêm']);
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
        $tag = Tag::find($id);
        return $tag;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
                'name' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
            ],

            [
                'name.required' => 'Tên thẻ không được để trống',
                'name.max' => 'Tên thẻ không được quá :max kí tự',
                'name.regex' => 'Tên thẻ không được chứa kí tự đặc biệt',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();
            $tag = Tag::find($data['id']);
            unset($data['_token']);
            unset($data['id']);
            $data['slug'] = str_slug($data['name']);
            $flag = $tag->update($data);
            if ($flag) {
                return response()->json(['is' => 'success', 'complete' => 'Thẻ được cập nhật thành công']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Thẻ chưa được cập nhật']);
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
        $post_tags = Tag::findOrFail($id)->post_tags()->delete();
        $tag = Tag::findOrFail($id)->delete();
        if ($tag) {
            return response()->json(['is' => 'success', 'complete' => 'Thẻ được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Thẻ chưa được xóa']);
    }
}
