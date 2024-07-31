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
        Schema::create('destination_details', function (Blueprint $table) {
            $table->id();
            $table->integer('des_id');
            $table->text('views');
            $table->text('activities');
            $table->text('foods');
            $table->text('festival');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_details');
    }
};
