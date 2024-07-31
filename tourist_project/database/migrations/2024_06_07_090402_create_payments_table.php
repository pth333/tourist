<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('p_order_id')->nullable();
            $table->integer('p_user_id')->nullable();
            $table->float('p_price')->nullable();
            $table->string('p_note')->nullable();
            $table->string('p_vnpay_response_code')->nullable()->comment('Mã phản hồi');
            $table->string('p_code_vnpay')->nullable()->comment('Mã giao dịch vnpay');
            $table->string('p_code_bank')->nullable()->comment('Mã ngân hàng');
            $table->dateTime('p_time')->nullable()->comment('Thời gian chuyển khoản');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
