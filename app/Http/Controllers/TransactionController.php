<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Order;
use Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('transaction.transaction_lists', ['transactions' => $transactions]);
    }

    public function pending()
    {
        $transactions = Transaction::where('status', 0)->get();
        return view('transaction.transaction_lists_pending', ['transactions' => $transactions]);
    }

    public function shipped()
    {
        $transactions =  Transaction::select('transactions.*', 'admins.name as manager')
            ->join('admins', 'admins.id', '=', 'transactions.admin_id_status_shipped')
            ->where('transactions.status', 1)->get();
        return view('transaction.transaction_lists_shipped', ['transactions' => $transactions]);
    }

    public function delivered()
    {
        $transactions =  Transaction::select('transactions.*', 'admins.name as manager')
            ->join('admins', 'admins.id', '=', 'transactions.admin_id_status_delivered')
            ->where('transactions.status', 2)->get();
        return view('transaction.transaction_lists_delivered', ['transactions' => $transactions]);
    }

    public function cancel()
    {
        $transactions =  Transaction::select('transactions.*', 'admins.name as manager')
            ->join('admins', 'admins.id', '=', 'transactions.admin_id_status_cancel')
            ->where('transactions.status', 3)->get();

        return view('transaction.transaction_lists_cancel', ['transactions' => $transactions]);
    }

    public function show($order_id)
    {
        $transaction = Transaction::where('order_id', $order_id)->first();
        $order = Order::where('order_id', $order_id)->get();

        return view('transaction.transaction_detail', ['transaction' => $transaction, 'order' => $order]);
    }

    public function update(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $data = $request->all();
            $transaction = Transaction::find($data['id']);
            if ($transaction->status == 0) {
                $admin_id_status_shipped = Auth::guard('admin')->user()->id;
                $transaction->admin_id_status_shipped = $admin_id_status_shipped;
                $transaction->status = 1;
            } else {
                if ($transaction->status == 1) {
                    $admin_id_status_delivered = Auth::guard('admin')->user()->id;
                    $transaction->admin_id_status_delivered = $admin_id_status_delivered;
                    $transaction->status = 2;

                    $products_order = DB::table('orders')
                        ->where('order_id', $transaction->order_id)
                        ->get();

                    foreach ($products_order as $item) {
                        $product = DB::table('products')
                            ->select('bought')
                            ->where('id', $item->product_id)
                            ->first();

                        $bought = $product->bought + $item->quantity;

                        DB::table('products')->where('id', $item->product_id)
                            ->update([
                                'bought' => $bought
                            ]);
                    }

                    if ($transaction->customer_id) {
                        $customer = Customer::find($transaction->customer_id);
                        if ($customer) {
                            $award = (int) (($transaction->amount + $transaction->score_awards) / 50);
                            // update score_awards for customer
                            $customer->score_awards = $customer->score_awards + $award;
                            // update money_payment_transactions for customer
                            $customer->money_payment_transactions = $customer->money_payment_transactions + $transaction->amount;
                            $customer->save();
                        }
                    }
                } 
            }

            $flag = $transaction->save();
        }

        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Đã cập nhật đơn hàng!']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Đã xảy ra lỗi!']);
    }

    public function note($id)
    {
        $transaction = Transaction::find($id);
        return $transaction;
    }

    public function cancelTransaction(Request $request, $id)
    {
        $data = $request->all();
        $transaction = Transaction::find($data['id']);

        $products_order = DB::table('orders')
            ->where('order_id', $transaction->order_id)
            ->get();

        foreach ($products_order as $item) {
            $product = DB::table('products')
                ->select('quantity')
                ->where('id', $item->product_id)
                ->first();

            $quantity = $product->quantity + $item->quantity;

            DB::table('products')->where('id', $item->product_id)
                ->update([
                    'quantity' => $quantity
                ]);
        }

        $order = DB::table('orders')->where('order_id', $transaction->order_id)
            ->update([
                'status' => 0
            ]);

        if ($transaction->customer_id) {
            $score = DB::table('customers')->select('score_awards')->where('id', $transaction->customer_id)->first();
            if ($score) {
                DB::table('customers')->where('id', $transaction->customer_id)
                    ->update([
                        'score_awards' => $score->score_awards + $transaction->score_awards,
                    ]);
            }
        }

        if (Auth::guard('admin')->check()) {
            $admin_id_status_cancel = Auth::guard('admin')->user()->id;
            $transaction->notes = $data['notes'];
            $transaction->admin_id_status_cancel = $admin_id_status_cancel;
            $transaction->status = 3;
            $flag = $transaction->save();
        }

        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Đơn hàng vừa bị hủy!']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Đơn hàng chưa bị hủy!']);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id)->delete();
        if ($transaction) {
            return response()->json(['is' => 'success', 'complete' => 'Một đơn hàng trong danh sách đã hủy vừa bị xóa khỏi hệ thống']);
        }
        return response()->json(['is' => 'unsuccess', 'uncomplete' => 'Đơn hàng trong danh sách đã hủy chưa được xóa khỏi hệ thống']);
    }

    public function reportTransaction(Request $request){
		
		if ($request->status == -1){
			$transactions = Transaction::whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->get();
		}
		else {
			$transactions = Transaction::whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->where('status', $request->status)->get();
		}
		return view('admin.report_transaction', ['from_date'=> $request->from_date, 'to_date'=> $request->to_date, 'status'=> $request->status, 'transactions' => $transactions]);
    }
    
}
