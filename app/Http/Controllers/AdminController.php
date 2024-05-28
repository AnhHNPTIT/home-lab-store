<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use Auth;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Manufacture;
use App\Models\Unit;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Admin;
use App\Models\Product;
use App\ProfileAdmin;
use Validator;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	public function homePage()
	{
		// So luong khach hang
		$count_customer = Customer::all()->count();

		// So luong nhan vien
		$count_collaborator = Admin::where('level', 0)->count();

		// So luong quan tri vien
		$count_admin = Admin::where('level', 1)->count();

		// Tong so tai khoan tren he thong
		$count_user_total = $count_customer + $count_collaborator + $count_admin;

		// So luong chu de
		$count_post_category = PostCategory::all()->count();

		// So luong the bai viet
		$count_tag = Tag::all()->count();

		// So luong bai viet
		$count_post = Post::all()->count();

		// So luong don hang da giao thanh cong
		$count_transaction_delivered = Transaction::where('status', 2)->count();

		// So luong nha san xuat
		$count_manufacture = Manufacture::all()->count();

		// So luong don vi tinh
		$count_unit = Unit::all()->count();

		// So luong san pham thuoc nhom Bổ sung vitamin & khoáng chất
		$total_vitamin_product = Product::where('product_category_id', 1)->where('status', 1)->count();

		// So luong san pham thuoc nhom Nước tăng lực & giải khát
		$total_energy_product = Product::where('product_category_id', 2)->where('status', 1)->count();

		// So luong san pham thuoc nhom Giàu chất xơ tiêu hóa
		$total_fiber_product = Product::where('product_category_id', 3)->where('status', 1)->count();

		// So luong san pham thuoc nhom Chức năng đặc biệt
		$total_special_product = Product::where('product_category_id', 4)->where('status', 1)->count();

		return view(
			'admin.home_page',
			compact(
				'count_customer',
				'count_user_total',
				'count_collaborator',
				'count_admin',
				'count_post_category',
				'count_tag',
				'count_post',
				'count_transaction_delivered',
				'count_manufacture',
				'count_unit',
				'total_vitamin_product',
				'total_energy_product',
				'total_fiber_product',
				'total_special_product'
			)
		);
	}

	public function index()
	{
		// So luong khach hang
		$count_customer = Customer::all()->count();

		// So luong nhan vien
		$count_collaborator = Admin::where('level', 0)->count();

		// So luong quan tri vien
		$count_admin = Admin::where('level', 1)->count();

		// Tong so tai khoan tren he thong
		$count_user_total = $count_customer + $count_collaborator + $count_admin;

		// So luong chu de
		$count_post_category = PostCategory::all()->count();

		// So luong the bai viet
		$count_tag = Tag::all()->count();

		// So luong bai viet
		$count_post = Post::all()->count();

		// So luong don hang da giao thanh cong
		$count_transaction_delivered = Transaction::where('status', 2)->count();

		// So luong nha san xuat
		$count_manufacture = Manufacture::all()->count();

		// So luong don vi tinh
		$count_unit = Unit::all()->count();

		// So luong san pham thuoc nhom Bổ sung vitamin & khoáng chất
		$total_vitamin_product = Product::where('product_category_id', 1)->where('status', 1)->count();

		// So luong san pham thuoc nhom Nước tăng lực & giải khát
		$total_energy_product = Product::where('product_category_id', 2)->where('status', 1)->count();

		// So luong san pham thuoc nhom Giàu chất xơ tiêu hóa
		$total_fiber_product = Product::where('product_category_id', 3)->where('status', 1)->count();

		// So luong san pham thuoc nhom Chức năng đặc biệt
		$total_special_product = Product::where('product_category_id', 4)->where('status', 1)->count();

		// So don hang trong moi thang den thoi diem hien tai
		$transaction_each_month = DB::select("SELECT MONTHNAME(created_at) as month, COUNT(id) AS count
		FROM transactions
		WHERE YEAR(created_at) = YEAR(CURDATE())
		GROUP BY month
		");

		$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		for ($i = 0; $i < count($month); $i++) {
			$flag = true;
			foreach ($transaction_each_month as $value) {
				if (strcmp($month[$i], $value->month) == 0) {
					$transactions_month[$i] = (int) $value->count;
					$flag = false;
				}
			}
			if ($flag) {
				$transactions_month[$i] = 0;
			}
		}

		// So don hang giao thanh cong trong moi thang den thoi diem hien tai
		$transaction_success_each_month = DB::select("SELECT MONTHNAME(created_at) as month, COUNT(id) AS count
		FROM transactions
		WHERE YEAR(created_at) = YEAR(CURDATE()) AND status = 2
		GROUP BY month
		");

		for ($i = 0; $i < count($month); $i++) {
			$flag = true;
			foreach ($transaction_success_each_month as $value) {
				if (strcmp($month[$i], $value->month) == 0) {
					$transactions_success_month[$i] = (int) $value->count;
					$flag = false;
				}
			}
			if ($flag) {
				$transactions_success_month[$i] = 0;
			}
		}

		// So luong tai khoan dang ki them tung thang
		$register_each_month = DB::select("SELECT MONTHNAME(created_at) as month, COUNT(id) as count
		FROM customers
		WHERE YEAR(created_at) = YEAR(CURDATE())
		GROUP BY month
		");

		for ($i = 0; $i < count($month); $i++) {
			$flag = true;
			foreach ($register_each_month as $value) {
				if (strcmp($month[$i], $value->month) == 0) {
					$register_month[$i] = (int) $value->count;
					$flag = false;
				}
			}
			if ($flag) {
				$register_month[$i] = 0;
			}
		}

		// Doanh thu mỗi tháng trong 1 năm
		// Tổng tiền nhập hàng
		$sum_money_prime_each_month = DB::select("SELECT MONTHNAME(TRANS.created_at) as month, 
												SUM(PROS.price_prime * ORDS.quantity)*1000 AS sum_money
		FROM transactions as TRANS
		JOIN orders as ORDS
		ON TRANS.order_id = ORDS.order_id
		JOIN products as PROS
		ON ORDS.product_id = PROS.id
		WHERE YEAR(TRANS.created_at) = YEAR(CURDATE()) AND TRANS.status = 2
		GROUP BY month
		");

		for ($i = 0; $i < count($month); $i++) {
			$flag = true;
			foreach ($sum_money_prime_each_month as $value) {
				if (strcmp($month[$i], $value->month) == 0) {
					$sum_money_prime_month[$i] = (int) $value->sum_money;
					$flag = false;
				}
			}
			if ($flag) {
				$sum_money_prime_month[$i] = 0;
			}
		}
		// Tổng tiền bán hàng
		$sum_money_sale_each_month = DB::select("SELECT MONTHNAME(created_at) as month, SUM(amount)*1000 AS sum_money
		FROM transactions
		WHERE YEAR(created_at) = YEAR(CURDATE()) AND status = 2
		GROUP BY month
		");

		for ($i = 0; $i < count($month); $i++) {
			$flag = true;
			foreach ($sum_money_sale_each_month as $value) {
				if (strcmp($month[$i], $value->month) == 0) {
					$sum_money_sale_month[$i] = (int) $value->sum_money;
					$flag = false;
				}
			}
			if ($flag) {
				$sum_money_sale_month[$i] = 0;
			}
		}

		return view(
			'admin.chart',
			compact(
				'count_customer',
				'count_user_total',
				'count_collaborator',
				'count_admin',
				'count_post_category',
				'count_tag',
				'count_post',
				'count_transaction_delivered',
				'count_manufacture',
				'count_unit',
				'total_vitamin_product',
				'total_energy_product',
				'total_fiber_product',
				'total_special_product',
				'transactions_success_month',
				'register_month',
				'sum_money_prime_month',
				'sum_money_sale_month'
			)
		);
	}

}
