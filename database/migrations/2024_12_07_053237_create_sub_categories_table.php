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
            Schema::create('sub_categories', function (Blueprint $table) {
                $table->id('sub_category_id');
                $table->string('sub_category_name');
                $table->unsignedBigInteger('category_id')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('sub_categories', function (Blueprint $table) {
                // Drop foreign key constraints
                $table->dropForeign(['category_id']);
            });

            Schema::dropIfExists('sub_categories');
        }
};
