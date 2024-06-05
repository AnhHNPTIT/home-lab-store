<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth_Admin\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\LogoutController as CustomerLogoutController;
use App\Http\Controllers\Customer\RegisterController as CustomerRegisterController;
use App\Http\Controllers\Customer\SearchController as CustomerSearchController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\CheckoutController as CustomerCheckoutController;
use App\Http\Controllers\Customer\AccountController as CustomerAccountController;
use App\Http\Controllers\Customer\ChangePasswordController as CustomerChangePasswordController;
use App\Http\Controllers\Customer\WishlistController as CustomerWishlistController;
use App\Http\Controllers\Customer\TransactionHistoryController as CustomerTransactionHistoryController;
use App\Http\Controllers\Customer\ContactController as CustomerContactController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;

// trang chu 
Route::get('/', function () {
	return view('home');
});

// login 
Route::get('/login', function () {
	return view('login');
});

// dang nhap 
Route::post('/login', [CustomerLoginController::class, 'postLogin']);

// dang xuat 
Route::get('/logout', [CustomerLogoutController::class, 'logout']);

// dang ky
Route::get('/register', function () {
	return view('register');
});
Route::post('/register', [CustomerRegisterController::class, 'register']);
// cap nhat thong tin
Route::get('/fulfill/information', [CustomerRegisterController::class, 'fulfill']);
// tao tai khoan
Route::post('/create/account', [CustomerRegisterController::class, 'createAccount']);

// tim kiem san pham 
Route::get('/search', [CustomerSearchController::class, 'search']);

// danh mục sản phẩm
Route::get('/danh-muc/{slug}', [CustomerProductController::class, 'index']);

// chi tiet san pham 
Route::get('/san-pham/{slug}', [CustomerHomeController::class, 'productDetail']);

// tat ca bai viet 
Route::get('/tin-tuc-su-kien', [CustomerHomeController::class, 'index']);

// bai viet theo tag 
Route::get('/tag/{slug}', [CustomerHomeController::class, 'postTag']);

// bai viet theo chuyen muc 
Route::get('/chuyen-muc/{slug}', [CustomerHomeController::class, 'postTopic']);

//chi tiet + noi dung bai viet  
Route::get('/tin-tuc-su-kien/{slug}', [CustomerHomeController::class, 'postDetail']);

// cart 
Route::post('/add/item', [CustomerCartController::class, 'addSpecialItem']);
Route::get('/checkout/cart', [CustomerCartController::class, 'index']);
Route::post('/checkout/cart', [CustomerCartController::class, 'addItem']);
Route::delete('/remove-cart/{id}', [CustomerCartController::class, 'remove']);
Route::get('/clear/cart', [CustomerCartController::class, 'clearCart']);
// increment 
Route::post('/increment/cart', [CustomerCartController::class, 'increment']);
// decrement 
Route::post('/decrement/cart', [CustomerCartController::class, 'decrement']);
Route::get('/checkout/cart/item/number', [CustomerCartController::class, 'getItemNumber']);

// checkout payment 
Route::get('/checkout/payment', [CustomerCheckoutController::class, 'index']);
Route::post('/checkout/payment', [CustomerCheckoutController::class, 'order']);

// order-received
Route::get('/checkout/order-received/{order_id}', [CustomerCheckoutController::class, 'orderReceived']);

Route::group(['prefix' => '/', 'middleware' => 'CheckUserLogin'], function () {
	// my account  
	Route::get('/my_account/{customer_id}', [CustomerAccountController::class, 'myAccount']);
	// update account information 
	Route::post('/my_account', [CustomerAccountController::class, 'updateMyAccount']);

	// change password 
	Route::get('/change/password', [CustomerChangePasswordController::class, 'getFormChangePassword']);
	Route::post('/change/password', [CustomerChangePasswordController::class, 'changePassword']);

	// wishlist 
	Route::get('/wishlist', [CustomerWishlistController::class, 'index']);
	Route::delete('/remove-wishlist/{product_id}', [CustomerWishlistController::class, 'delete']);

	// my transactions 
	Route::get('/transaction/history/{customer_id}', [CustomerTransactionHistoryController::class, 'myTransaction']);
	// order detail 
	Route::get('/transaction/detail/{order_id}', [CustomerTransactionHistoryController::class, 'myOrder']);
});

// add item on wishlist 
Route::post('/wishlist', [CustomerWishlistController::class, 'addWishlist']);

// link 
Route::get('/gioi-thieu', function () {
	return view('introduction');
});

Route::get('/lien-he', [CustomerContactController::class, 'getFormContact']);
Route::post('/lien-he', [CustomerContactController::class, 'postFormContact']);

// admin
Route::group(['prefix' => 'admin', 'middleware' => 'CheckAdminLogin'], function () {
	// customer member 
	Route::get('/user/customer', [UserController::class, 'customer']);
	Route::put('/user/customer/{id}', [UserController::class, 'updateCustomer']);
	Route::delete('/user/customer/{id}', [UserController::class, 'destroyCustomer']);
	Route::get('/user/customer/{id}', [UserController::class, 'show']);

	// collaborator member 
	Route::get('/user/collaborator', [UserController::class, 'collaborator']);
	Route::post('/user/collaborator', [UserController::class, 'store']);
	Route::put('/user/collaborator/{id}', [UserController::class, 'updateCollaborator']);
	Route::get('/user/collaborator/{id}', [UserController::class, 'showCollaborator']);
	Route::post('/user/collaborator/update', [UserController::class, 'updateInformationCollaborator']);
	Route::delete('/user/collaborator/{id}', [UserController::class, 'destroyCollaborator']);
	Route::get('/new/collaborator', function () {
		return view('user.new_collaborator');
	});

	// transaction
	Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);

	// report chart
	Route::get('/chart', [AdminController::class, 'index']);
	Route::get('/report_product', function () {
		return view('admin.report_product');
	});
	Route::get('/report_transaction', function () {
		return view('admin.report_transaction');
	});
	Route::post('/report_product/{id}', [ProductController::class, 'reportProduct']);
	Route::get('/report_product/{id}', [ProductController::class, 'reportProduct']);
	Route::post('/report_transaction/from_date={from_date}&to_date={to_date}&status={status}', [TransactionController::class, 'reportTransaction']);
	Route::get('/report_transaction/from_date={from_date}&to_date={to_date}&status={status}', [TransactionController::class, 'reportTransaction']);
});

// admin-collaborator
Route::group(['prefix' => 'admin', 'middleware' => 'CheckAdmin'], function () {

	// get home page admin 
	Route::get('/', [AdminController::class, 'homePage']);
	Route::get('/home', [AdminController::class, 'homePage']);

	// get change pass 
	Route::get('/change/password', [LoginController::class, 'getChangePassword']);
	Route::post('/change/password', [LoginController::class, 'changePassword']);

	// post category 
	Route::resource('post-category', PostCategoryController::class);
	Route::post('/update-post-category', [PostCategoryController::class, 'edit']);
	Route::get('/new/post-category', function () {
		return view('post_category.new_post_category');
	});

	// posts 
	Route::resource('post', PostController::class);
	Route::get('post/detail/{id}', [PostController::class, 'showPost']);
	Route::post('post/update', [PostController::class, 'updatePost']);
	Route::get('/new/post', function () {
		return view('post.new_post');
	});

	// tags 
	Route::resource('tag', TagController::class);
	Route::get('/new/tag', function () {
		return view('tag.new_tag');
	});

	// manufacturers 
	Route::get('/manufacturer', [ManufactureController::class, 'index']);
	Route::get('/manufacturer/{id}', [ManufactureController::class, 'show']);
	Route::put('/manufacturer/{id}', [ManufactureController::class, 'update']);
	Route::post('/manufacturer', [ManufactureController::class, 'store']);
	Route::get('/new/manufacturer', function () {
		return view('manufacturer.new_manufacturer');
	});
	Route::delete('/manufacturer/{id}', [ManufactureController::class, 'destroy']);

	// units 
	Route::get('/unit', [UnitController::class, 'index']);
	Route::get('/unit/{id}', [UnitController::class, 'show']);
	Route::put('/unit/{id}', [UnitController::class, 'update']);
	Route::post('/unit', [UnitController::class, 'store']);
	Route::get('/new/unit', function () {
		return view('unit.new_unit');
	});
	Route::delete('/unit/{id}', [UnitController::class, 'destroy']);

	// products 
	Route::get('/product', [ProductController::class, 'index']);
	Route::get('/product/detail/{id}', [ProductController::class, 'show']);
	Route::post('/product/update', [ProductController::class, 'update']);
	Route::post('/product', [ProductController::class, 'store']);
	Route::get('/new/product', function () {
		return view('product.new_product');
	});
	Route::delete('/product/{id}', [ProductController::class, 'destroy']);
	Route::put('/update-status-product/{id}', [ProductController::class, 'updateStatus']);

	// transactions
	Route::get('/transaction', [TransactionController::class, 'index']);
	Route::get('/transaction_pending', [TransactionController::class, 'pending']);
	Route::get('/transaction_shipped', [TransactionController::class, 'shipped']);
	Route::get('/transaction_delivered', [TransactionController::class, 'delivered']);
	Route::get('/transaction_cancel', [TransactionController::class, 'cancel']);
	Route::get('/transaction/{order_id}', [TransactionController::class, 'show']);
	Route::get('/transaction_note/{id}', [TransactionController::class, 'note']);
	Route::put('/transaction/{id}', [TransactionController::class, 'update']);
	Route::put('/transaction/cancel/{id}', [TransactionController::class, 'cancelTransaction']);
	Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);

	// contacts
	Route::get('/contact', [ContactController::class, 'index']);
	Route::put('/update-status-contact/{id}', [ContactController::class, 'updateStatus']);
});

// admin
Route::group(['prefix' => 'admin'], function () {
	Route::get('/login', [LoginController::class, 'showLoginForm']);
	Route::post('/login', [LoginController::class, 'postLoginAdmin']);
	Route::get('/logout', [LoginController::class, 'logoutAdmin']);
});