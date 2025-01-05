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
        Schema::create('stocks_history', function (Blueprint $table) {
            $table->id('stock_history_id');
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->integer('quantity_change');
            $table->enum('action', ['stock_in', 'stock_out']);
            $table->timestamps();

            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_history');
    }
};
