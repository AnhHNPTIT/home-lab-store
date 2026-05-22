<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'transactions';
	protected $fillable  = [
		'order_id', 'customer_id', 'name', 'phone_number', 'address',
		'customer_notes', 'notes', 'amount', 'score_awards',
		'payment_method', 'payment_status', 'vnpay_txn_ref', 'vnpay_transaction_no', 'paid_at',
		'admin_id_status_shipped', 'admin_id_status_delivered',
		'status'
	];

	protected $casts = [
		'paid_at' => 'datetime',
	];
}
