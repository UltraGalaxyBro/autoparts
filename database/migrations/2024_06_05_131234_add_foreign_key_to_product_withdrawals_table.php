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
        Schema::table('product_withdrawals', function (Blueprint $table) {
            $table->unsignedInteger('product_sale_id')->after('completed_by')->nullable()->references('id')->on('product_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_withdrawals', function (Blueprint $table) {
            $table->dropColumn('product_sale_id');
        });
    }
};
