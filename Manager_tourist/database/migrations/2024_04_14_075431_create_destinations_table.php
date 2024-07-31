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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name_des');
            $table->string('address');
            $table->text('description');
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->integer('category_id');
            $table->integer('user_id');
            $table->string('feature_image_name');
            $table->string('feature_image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
