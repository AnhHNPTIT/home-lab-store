<?php

namespace App\Services;

use App\Models\Transaction;

class VnpayService
{
    public function buildPaymentUrl(Transaction $transaction, string $ipAddress): string
    {
        $config = config('vnpay');
        $txnRef = $this->buildTxnRef($transaction);
        $amount = $this->toVnpayAmount($transaction->amount);

        $params = [
            'vnp_Version' => $config['version'],
            'vnp_Command' => $config['command'],
            'vnp_TmnCode' => $config['tmn_code'],
            'vnp_Amount' => $amount,
            'vnp_CurrCode' => $config['curr_code'],
            'vnp_TxnRef' => $txnRef,
            'vnp_OrderInfo' => 'Thanh toan don hang ' . $transaction->order_id,
            'vnp_OrderType' => 'other',
            'vnp_Locale' => $config['locale'],
            'vnp_ReturnUrl' => $config['return_url'],
            'vnp_IpAddr' => $ipAddress,
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_ExpireDate' => date('YmdHis', strtotime('+15 minutes')),
        ];

        ksort($params);
        $hashData = $this->buildHashData($params);
        $secureHash = hash_hmac('sha512', $hashData, $config['hash_secret']);
        $query = $hashData . '&vnp_SecureHash=' . $secureHash;

        return $config['url'] . '?' . $query;
    }

    public function verifyReturn(array $input): bool
    {
        $secureHash = $input['vnp_SecureHash'] ?? '';
        unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);

        ksort($input);
        $hashData = $this->buildHashData($input);
        $calculated = hash_hmac('sha512', $hashData, config('vnpay.hash_secret'));

        return hash_equals($calculated, $secureHash);
    }

    public function isSuccessResponse(array $input): bool
    {
        return ($input['vnp_ResponseCode'] ?? '') === '00'
            && ($input['vnp_TransactionStatus'] ?? '') === '00';
    }

    public function parseTxnRef(string $txnRef): ?string
    {
        $parts = explode('-', $txnRef, 2);

        return $parts[0] ?? null;
    }

    public function buildTxnRef(Transaction $transaction): string
    {
        return $transaction->order_id . '-' . $transaction->id;
    }

    public function toVnpayAmount(float $amountInThousands): int
    {
        return (int) round($amountInThousands * 1000 * 100);
    }

    private function buildHashData(array $params): string
    {
        $parts = [];
        foreach ($params as $key => $value) {
            if ($value === '' || $value === null) {
                continue;
            }
            $parts[] = urlencode((string) $key) . '=' . urlencode((string) $value);
        }

        return implode('&', $parts);
    }
}
