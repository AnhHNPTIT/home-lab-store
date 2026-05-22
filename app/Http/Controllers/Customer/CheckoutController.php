<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\OrderCompletionService;
use App\Services\VnpayService;
use App\Support\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class CheckoutController extends Controller
{
    public function __construct(
        private VnpayService $vnpay,
        private OrderCompletionService $orderCompletion
    ) {
    }

    public function index()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');

            foreach ($cart as $id => $product) {
                $item = Product::where('id', $id)->first();
                if ($product['qty'] > $item->quantity) {
                    return view('shopping_cart', ['limit' => 'Sản phẩm ' . $product['name'] . ' không đáp ứng đủ số lượng! Sản phẩm này hiện có số lượng là ' . $item->quantity . '.']);
                }
            }

            $order_id = "ORD" . "" . date('YmdHis') . strtoupper(str_random(3));
            foreach ($cart as $id => $product) {
                $data = [];
                $data['order_id'] = $order_id;
                $data['product_id'] = $id;
                $data['name'] = $product['name'];
                $data['slug'] = $product['slug'];
                $data['code'] = $product['code'];
                $data['image'] = $product['image'];
                $data['price'] = $product['price'];
                $data['price_sale'] = $product['price_sale'];
                $data['quantity'] = $product['qty'];

                Order::create($data);
            }

            $orders = Order::where('status', 0)->where('order_id', $order_id)->get();
            return view('checkout', ['orders' => $orders, 'order_id' => $order_id]);
        }
        return view('checkout');
    }

    public function order(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'phone_number' => 'required|max:11',
                'address' => 'required',
                'payment_method' => 'required|in:cod,vnpay',
            ],
            [
                'name.required' => 'Tên khách hàng không được để trống',
                'name.max' => 'Tên khách hàng không được nhiều hơn 255 kí tự',
                'phone_number.required' => 'Số điện thoại không được để trống',
                'address.required' => 'Bạn chưa nhập địa chỉ',
                'phone_number.max' => 'Số điện thoại không quá 11 số',
                'payment_method.required' => 'Vui lòng chọn hình thức thanh toán',
                'payment_method.in' => 'Hình thức thanh toán không hợp lệ',
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $paymentMethod = $request->payment_method;

        try {
            $data = $this->buildTransactionData($request);
        } catch (\InvalidArgumentException $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        if ($paymentMethod === PaymentMethod::VNPAY) {
            return $this->placeVnpayOrder($request, $data);
        }

        return $this->placeCodOrder($request, $data);
    }

    public function orderReceived($order_id)
    {
        $order = Transaction::where('order_id', $order_id)->first();
        $order_detail = Order::where('order_id', $order_id)->where('status', 1)->get();

        if ($order && $order->payment_method === PaymentMethod::VNPAY && $order->payment_status !== 'paid') {
            return redirect('/checkout/payment')->withErrors('Đơn hàng chưa được thanh toán qua VNPay.');
        }

        if (isset($order) && $order_detail->isNotEmpty()) {
            return view('order_received', [
                'success' => 'Đơn hàng của bạn đã được tiếp nhận',
                'order' => $order,
                'order_detail' => $order_detail,
            ]);
        }
        return view('404');
    }

    private function buildTransactionData(Request $request): array
    {
        $data = [
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'customer_notes' => $request->note,
            'score_awards' => 0,
        ];

        if ($request->customer_id) {
            $data['customer_id'] = $request->customer_id;
            if ($request->score_awards == 1) {
                $score = DB::table('customers')->select('score_awards')->where('id', $data['customer_id'])->first();
                $data['score_awards'] = $score->score_awards;
                if ($request->score_awards_payment) {
                    $input_score = (float) $request->score_awards_payment;
                    if ($input_score <= 0 || $input_score > $score->score_awards) {
                        throw new \InvalidArgumentException('Số điểm thanh toán không hợp lệ!');
                    }
                    if ($input_score <= $data['amount']) {
                        $data['amount'] = $data['amount'] - $input_score;
                        DB::table('customers')->where('id', $data['customer_id'])
                            ->update(['score_awards' => $data['score_awards'] - $input_score]);
                        $data['score_awards'] = $input_score;
                    } else {
                        DB::table('customers')->where('id', $data['customer_id'])
                            ->update(['score_awards' => $data['score_awards'] - $data['amount']]);
                        $data['score_awards'] = $data['amount'];
                        $data['amount'] = 0;
                    }
                } else {
                    throw new \InvalidArgumentException('Số điểm thanh toán không hợp lệ!');
                }
            }
        }

        return $data;
    }

    private function placeCodOrder(Request $request, array $data)
    {
        $data = array_merge($data, [
            'payment_method' => PaymentMethod::COD,
            'payment_status' => 'pending',
        ]);

        $transaction = Transaction::updateOrCreate(
            ['order_id' => $data['order_id']],
            $data
        );

        if (Session::has('cart')) {
            Session::forget('cart');
        }

        if (!$transaction) {
            return view('500');
        }

        if (!$this->orderCompletion->complete($transaction)) {
            return Redirect::back()->withErrors('Sản phẩm không đáp ứng đủ số lượng trong kho.');
        }

        return redirect('/checkout/order-received/' . $transaction->order_id);
    }

    private function placeVnpayOrder(Request $request, array $data)
    {
        if ((float) $data['amount'] <= 0) {
            return Redirect::back()->withErrors('Đơn hàng đã thanh toán bằng điểm thưởng, không cần thanh toán VNPay.');
        }

        $data = array_merge($data, [
            'payment_method' => PaymentMethod::VNPAY,
            'payment_status' => 'pending',
            'status' => 0,
        ]);

        $transaction = Transaction::updateOrCreate(
            ['order_id' => $data['order_id']],
            $data
        );

        if (Session::has('cart')) {
            Session::forget('cart');
        }

        $paymentUrl = $this->vnpay->buildPaymentUrl($transaction, $request->ip());

        return redirect()->away($paymentUrl);
    }
}
