<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        /*Schema::create('posts', function (Blueprint $table) {
            Schema::dropIfExists('posts');
            $table->string('name');
            $table->integer('amount');
            $table->unsignedInteger('price'); // 0以上の整数値を格納
        });
        */
        Schema::create('stock', function (Blueprint $table) {
            Schema::dropIfExists('stock');
            $table->string('name', 8);
            $table->integer('amount');
            $table->decimal('price', 8, 2); // 合計8桁、少数点以下2桁までの値を格納
            $table->timestamps();
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
