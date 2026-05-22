<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class OrderCompletionService
{
    public function complete(Transaction $transaction): bool
    {
        if ($this->ordersAlreadyConfirmed($transaction->order_id)) {
            return true;
        }

        $productsOrderDetail = DB::table('orders')
            ->where('order_id', $transaction->order_id)
            ->get();

        foreach ($productsOrderDetail as $item) {
            $product = DB::table('products')
                ->select('quantity', 'name')
                ->where('id', $item->product_id)
                ->first();

            if (!$product) {
                return false;
            }

            $quantity = $product->quantity - $item->quantity;
            if ($quantity < 0) {
                return false;
            }

            DB::table('products')->where('id', $item->product_id)->update([
                'quantity' => $quantity,
            ]);
        }

        DB::table('orders')->where('order_id', $transaction->order_id)->update([
            'status' => 1,
        ]);

        return true;
    }

    private function ordersAlreadyConfirmed(string $orderId): bool
    {
        return DB::table('orders')
            ->where('order_id', $orderId)
            ->where('status', 1)
            ->exists();
    }
}
