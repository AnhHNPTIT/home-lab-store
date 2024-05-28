<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use Illuminate\Http\Request;
use Validator;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = PostCategory::all();
        return view('post_category.post_categories_list', ['categories' => $categories]);
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
                'sort_id' => 'required|numeric|integer|min:0',
            ],
            [
                'name.required' => 'Chủ đề bài viết không được để trống',
                'name.max' => 'Chủ đề bài viết không được nhiều hơn :max kí tự',
                'name.regex' => 'Chủ đề bài viết không được chứa kí tự đặc biệt',
                'sort_id.numeric' => 'Thứ tự sắp xếp phải là số',
                'sort_id.min' => 'Thứ tự sắp xếp phải là số lớn hơn hoặc bằng 0',
                'sort_id.integer' => 'Thứ tự sắp xếp phải là số nguyên',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();
            unset($data['_token']);
            $data['slug'] = str_slug($data['name']);

            $category = PostCategory::create($data);

            if (isset($category)) {
                return response()->json(['is' => 'success', 'complete' => 'Chủ đề bài viết được thêm thành công']);
            } else {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Chủ đề bài viết chưa được thêm']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = PostCategory::find($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
                'sort_id' => 'required|numeric|integer|min:0',
            ],
            [
                'name.required' => 'Chủ đề bài viết không được để trống',
                'name.max' => 'Chủ đề bài viết không được nhiều hơn :max kí tự',
                'name.regex' => 'Chủ đề bài viết không được chứa kí tự đặc biệt',
                'sort_id.numeric' => 'Thứ tự sắp xếp phải là số',
                'sort_id.min' => 'Thứ tự sắp xếp phải là số lớn hơn hoặc bằng 0',
                'sort_id.integer' => 'Thứ tự sắp xếp phải là số nguyên',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();
            $category = PostCategory::find($data['id']);
            $data['slug'] = str_slug($data['name']);
            unset($data['_token']);
            unset($data['id']);
            $flag = $category->update($data);
            if ($flag) {
                return response()->json(['is' => 'success', 'complete' => 'Chủ đề  bài viết đã được cập nhật']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Chủ đề  bài viết chưa được cập nhật']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $category = PostCategory::find($data['id']);
        unset($data['_token']);
        unset($data['id']);
        $flag = $category->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = PostCategory::findOrFail($id)->posts()->delete();
        $category = PostCategory::findOrFail($id)->delete();
        if ($category) {
            return response()->json(['is' => 'success', 'complete' => 'Chủ đề  bài viết đã được xóa']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Chủ đề  bài viết chưa được xóa']);
    }
}
