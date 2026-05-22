<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_method', 20)->default('cod')->after('score_awards');
            $table->string('payment_status', 20)->default('pending')->after('payment_method');
            $table->string('vnpay_txn_ref', 100)->nullable()->after('payment_status');
            $table->string('vnpay_transaction_no', 100)->nullable()->after('vnpay_txn_ref');
            $table->timestamp('paid_at')->nullable()->after('vnpay_transaction_no');
            $table->index('payment_method');
            $table->index('payment_status');
        });

        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string('order_id');
            $table->string('gateway', 50)->default('vnpay');
            $table->string('vnp_txn_ref', 100)->nullable();
            $table->string('vnp_transaction_no', 100)->nullable();
            $table->unsignedBigInteger('amount')->default(0);
            $table->string('response_code', 10)->nullable();
            $table->string('bank_code', 50)->nullable();
            $table->longText('raw_response')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_logs');

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['payment_method']);
            $table->dropIndex(['payment_status']);
            $table->dropColumn([
                'payment_method',
                'payment_status',
                'vnpay_txn_ref',
                'vnpay_transaction_no',
                'paid_at',
            ]);
        });
    }
};
