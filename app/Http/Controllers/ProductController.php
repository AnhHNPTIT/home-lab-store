<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    // Lấy danh sách sản phẩm
    public function index()
    {
        $products = Product::select("products.*", "product_categories.name as product_category_name")
            ->join("product_categories", "product_categories.id", "=", "products.product_category_id")
            ->orderBy('created_at', 'desc')
            ->get();
        return view('product.products_list', ['products' => $products]);
    }

    // Thêm sản phẩm mới
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required',
                'product_category_id' => 'required',
                'manufacturer_id' => 'required',
                'price_prime' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'unit_id' => 'required',
                'price_sale' => 'required|numeric|min:0',
                'quantity' => 'required|numeric|integer|min:0',
                'status' => 'required',
            ],

            [
                'name.required' => 'Tên sản phẩm không được để trống',
                'code.required' => 'Mã sản phẩm không được để trống',
                'product_category_id.required' => 'Phân loại sản phẩm không được để trống',
                'manufacturer_id.required' => 'Nhà sản xuất không được để trống',
                'price_prime.required' => 'Giá nhập sản phẩm không được để trống',
                'price_prime.numeric' => 'Giá nhập của sản phẩm phải là số',
                'price_prime.min' => 'Giá nhập của sản phẩm phải lớn hơn hoặc bằng 0',
                'price.required' => 'Giá niêm yết sản phẩm không được để trống',
                'price.numeric' => 'Giá niêm yết của sản phẩm phải là số',
                'price.min' => 'Giá niêm yết của sản phẩm phải lớn hơn hoặc bằng 0',
                'unit_id.required' => 'Đơn vị tính không được để trống',
                'price_sale.required' => 'Giảm giá đối với sản phẩm không được để trống',
                'price_sale.numeric' => 'Giá giảm đối với sản phẩm phải là số',
                'price_sale.min' => 'Giá giảm đối với sản phẩm phải lớn hơn hoặc bằng 0',
                'quantity.required' => 'Số lượng sản phẩm trong kho không được để trống',
                'quantity.numeric' => 'Số lượng sản phẩm phải là số',
                'quantity.min' => 'Số lượng sản phẩm phải là số lớn hơn hoặc bằng 0',
                'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
                'status.required' => 'Trạng thái chỉ định sản phẩm không được để trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();

            $flag_code = Product::where('code', $data['code'])->first();
            if ($flag_code) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Mã sản phẩm ' . $data['code'] . ' đã tồn tại']);
            }

            if ($data['price_prime'] > $data['price']) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Giá nhập phải nhỏ hơn hoặc bằng giá niêm yết của sản phẩm']);
            }
            if ($data['price_prime'] > $data['price_sale']) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Giá nhập phải nhỏ hơn hoặc bằng giá bán của sản phẩm']);
            }
            if ($data['price'] < $data['price_sale']) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Giảm giá phải nhỏ hơn hoặc bằng giá niêm yết của sản phẩm']);
            }

            unset($data['_token']);
            $time = time();
            $data['slug'] = str_slug($data['name']) . '-' . $time;
            if ($files = $request->file('image')) {
                $destinationPath = 'images/products/'; // upload path
                $time = time();
                $fileName = $time . "" . date('YmdHis') . "" . $files->hashName();
                $files->move($destinationPath, $fileName);
                $data['image'] = $fileName;
            }

            if (Auth::guard('admin')->check()) {
                $data['admin_id'] = Auth::guard('admin')->user()->id;
            }
            $data['bought'] = 0;
            $data['view_count'] = 0;
            unset($data['_token']);
            $product = Product::create($data);

            if (isset($product)) {
                return response()->json(['is' => 'success', 'complete' => 'Sản phẩm của bạn được thêm thành công']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Sản phẩm của bạn chưa được thêm']);
        }
    }

    // Lấy thông tin chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            return view('product.product_detail', ['product' => $product]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required',
                'product_category_id' => 'required',
                'manufacturer_id' => 'required',
                'price_prime' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'unit_id' => 'required',
                'price_sale' => 'required|numeric|min:0',
                'quantity' => 'required|numeric|integer|min:0',
                'status' => 'required',
            ],

            [
                'name.required' => 'Tên sản phẩm không được để trống',
                'code.required' => 'Mã sản phẩm không được để trống',
                'product_category_id.required' => 'Phân loại sản phẩm không được để trống',
                'manufacturer_id.required' => 'Nhà sản xuất không được để trống',
                'price_prime.required' => 'Giá nhập sản phẩm không được để trống',
                'price_prime.numeric' => 'Giá nhập của sản phẩm phải là số',
                'price_prime.min' => 'Giá nhập của sản phẩm phải lớn hơn hoặc bằng 0',
                'price.required' => 'Giá niêm yết sản phẩm không được để trống',
                'price.numeric' => 'Giá niêm yết của sản phẩm phải là số',
                'price.min' => 'Giá niêm yết của sản phẩm phải lớn hơn hoặc bằng 0',
                'unit_id.required' => 'Đơn vị tính không được để trống',
                'price_sale.required' => 'Giảm giá đối với sản phẩm không được để trống',
                'price_sale.numeric' => 'Giá giảm đối với sản phẩm phải là số',
                'price_sale.min' => 'Giá giảm đối với sản phẩm phải lớn hơn hoặc bằng 0',
                'quantity.required' => 'Số lượng sản phẩm trong kho không được để trống',
                'quantity.numeric' => 'Số lượng sản phẩm phải là số',
                'quantity.min' => 'Số lượng sản phẩm phải là số lớn hơn hoặc bằng 0',
                'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
                'status.required' => 'Trạng thái chỉ định sản phẩm không được để trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        } else {
            $data = $request->all();

            $flag_code = Product::where('code', $data['code'])->where('id', '!=', $data['id'])->first();
            if ($flag_code) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Mã sản phẩm ' . $data['code'] . ' đã tồn tại']);
            }

            if ($data['price_prime'] > $data['price']) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Giá nhập phải nhỏ hơn hoặc bằng giá niêm yết của sản phẩm']);
            }
            if ($data['price_prime'] > $data['price_sale']) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Giá nhập phải nhỏ hơn hoặc bằng giá bán của sản phẩm']);
            }
            if ($data['price'] < $data['price_sale']) {
                return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Giảm giá phải nhỏ hơn hoặc bằng giá niêm yết của sản phẩm']);
            }

            unset($data['_token']);
            $time = time();
            $data['slug'] = str_slug($data['name']) . '-' . $time;
            if (Auth::guard('admin')->check()) {
                $data['admin_id'] = Auth::guard('admin')->user()->id;
            }

            if ($files = $request->file('image')) {
                $destinationPath = 'images/products/'; // upload path
                $time = time();
                $fileName = $time . "" . date('YmdHis') . "" . $files->hashName();
                $files->move($destinationPath, $fileName);
                $data['image'] = $fileName;

                $product = Product::where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'code' => $data['code'],
                        'product_category_id' => $data['product_category_id'],
                        'manufacturer_id' => $data['manufacturer_id'],
                        'description' => $data['description'],
                        'image' => $data['image'],
                        'price_prime' => $data['price_prime'],
                        'price' => $data['price'],
                        'unit_id' => $data['unit_id'],
                        'price_sale' => $data['price_sale'],
                        'quantity' => $data['quantity'],
                        'status' => $data['status'],
                    ]);
            } else {
                $product = Product::where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'code' => $data['code'],
                        'product_category_id' => $data['product_category_id'],
                        'manufacturer_id' => $data['manufacturer_id'],
                        'description' => $data['description'],
                        'price_prime' => $data['price_prime'],
                        'price' => $data['price'],
                        'unit_id' => $data['unit_id'],
                        'price_sale' => $data['price_sale'],
                        'quantity' => $data['quantity'],
                        'status' => $data['status'],
                    ]);
            }

            if ($product) {
                return response()->json(['is' => 'success', 'complete' => 'Một sản phẩm đã được cập nhật thành công']);
            }
            return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Một sản phẩm chưa được cập nhật thành công']);
        }
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id)->delete();
        if ($product) {
            return response()->json(['is' => 'success', 'complete' => 'Một sản phẩm đã được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Một sản phẩm chưa được xóa']);
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->all();
        unset($data['_token']);
        $product = Product::find($data['id']);

        if ($product->status == 0) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }

        $flag = $product->save();
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Một sản phẩm đã được cập nhật trạng thái thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Một sản phẩm chưa được cập nhật trạng thái']);
    }

    public function reportProduct(Request $request){
		if ($request->id == 'max_view'){
			$products = Product::where('status', 1)->orderBy('view_count', 'desc')->take(50)->get();
        	return view('admin.report_product', ['parameter'=> $request->id, 'products' => $products]);
		}
		elseif ($request->id == 'max_bought'){
			$products = Product::where('status', 1)->orderBy('bought', 'desc')->take(50)->get();
        	return view('admin.report_product', ['parameter'=> $request->id, 'products' => $products]);
		}
		elseif ($request->id == 'sold_out'){
			$products = Product::where('status', 1)->where('quantity', 0)->take(50)->get();
        	return view('admin.report_product', ['parameter'=> $request->id, 'products' => $products]);
		}
		
    }
    
}
