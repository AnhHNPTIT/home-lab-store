<?php

namespace App\Support;

class PaymentMethod
{
    public const COD = 'cod';
    public const VNPAY = 'vnpay';

    public static function label(?string $method): string
    {
        return match ($method) {
            self::VNPAY => 'VNPay',
            self::COD => 'COD',
            default => 'COD',
        };
    }

    public static function labelLong(?string $method): string
    {
        return match ($method) {
            self::VNPAY => 'Thanh toán online (VNPay)',
            self::COD => 'Thanh toán khi nhận hàng (COD)',
            default => 'Thanh toán khi nhận hàng (COD)',
        };
    }

    public static function paymentStatusLabel(?string $status): string
    {
        return match ($status) {
            'paid' => 'Đã thanh toán',
            'pending' => 'Chờ thanh toán',
            'failed' => 'Thanh toán thất bại',
            'cancelled' => 'Đã hủy',
            default => '—',
        };
    }
}
