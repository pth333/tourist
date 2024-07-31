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
        Schema::create('payment_momos', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('m_order_id')->nullable();
            $table->integer('m_user_id')->nullable();
            $table->float('m_price')->nullable();
            $table->string('m_note')->nullable();
            $table->string('m_code_trans')->nullable()->comment('Mã giao dịch');
            $table->string('m_pay_type')->nullable()->comment('Loại thanh toán');
            $table->dateTime('m_time')->nullable()->comment('Thời gian chuyển khoản');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_momos');
    }
};
