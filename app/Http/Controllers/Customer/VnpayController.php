<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\OrderCompletionService;
use App\Services\VnpayService;
use App\Support\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VnpayController extends Controller
{
    public function __construct(
        private VnpayService $vnpay,
        private OrderCompletionService $orderCompletion
    ) {
    }

    public function return(Request $request)
    {
        $input = $request->all();

        if (!$this->vnpay->verifyReturn($input)) {
            return redirect('/checkout/payment')->withErrors('Xác thực thanh toán VNPay không hợp lệ.');
        }

        $orderId = $this->vnpay->parseTxnRef($input['vnp_TxnRef'] ?? '');
        $transaction = $orderId
            ? Transaction::where('order_id', $orderId)->where('payment_method', PaymentMethod::VNPAY)->latest('id')->first()
            : null;

        if (!$transaction) {
            return view('404');
        }

        if ($this->vnpay->isSuccessResponse($input)) {
            $this->markPaid($transaction, $input);

            if (!$this->orderCompletion->complete($transaction)) {
                return redirect('/checkout/payment')->withErrors('Không đủ tồn kho để hoàn tất đơn hàng.');
            }

            return redirect('/checkout/order-received/' . $transaction->order_id);
        }

        $transaction->update([
            'payment_status' => 'failed',
            'notes' => 'VNPay: ' . ($input['vnp_ResponseCode'] ?? 'unknown'),
        ]);

        return redirect('/checkout/payment')->withErrors('Thanh toán VNPay không thành công. Vui lòng thử lại hoặc chọn COD.');
    }

    public function ipn(Request $request)
    {
        $input = $request->all();

        if (!$this->vnpay->verifyReturn($input)) {
            return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
        }

        $orderId = $this->vnpay->parseTxnRef($input['vnp_TxnRef'] ?? '');
        $transaction = $orderId
            ? Transaction::where('order_id', $orderId)->where('payment_method', PaymentMethod::VNPAY)->latest('id')->first()
            : null;

        if (!$transaction) {
            return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
        }

        if ($this->vnpay->isSuccessResponse($input)) {
            if ($transaction->payment_status !== 'paid') {
                $this->markPaid($transaction, $input);
                if (!$this->orderCompletion->complete($transaction)) {
                    return response()->json(['RspCode' => '99', 'Message' => 'Insufficient stock']);
                }
            }

            return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
        }

        return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
    }

    private function markPaid(Transaction $transaction, array $input): void
    {
        $transaction->update([
            'payment_status' => 'paid',
            'vnpay_txn_ref' => $input['vnp_TxnRef'] ?? $transaction->vnpay_txn_ref,
            'vnpay_transaction_no' => $input['vnp_TransactionNo'] ?? null,
            'paid_at' => now(),
        ]);

        $this->logPayment($transaction, $input);
    }

    private function logPayment(Transaction $transaction, array $input): void
    {
        try {
            DB::table('payment_logs')->insert([
                'transaction_id' => $transaction->id,
                'order_id' => $transaction->order_id,
                'gateway' => 'vnpay',
                'vnp_txn_ref' => $input['vnp_TxnRef'] ?? null,
                'vnp_transaction_no' => $input['vnp_TransactionNo'] ?? null,
                'amount' => (int) ($input['vnp_Amount'] ?? 0),
                'response_code' => $input['vnp_ResponseCode'] ?? null,
                'bank_code' => $input['vnp_BankCode'] ?? null,
                'raw_response' => json_encode($input),
                'status' => $this->vnpay->isSuccessResponse($input) ? 'success' : 'failed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('payment_logs insert failed: ' . $e->getMessage());
        }
    }
}
