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
        Schema::create('product_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('supplier_code')->nullable();
            $table->foreignId('headquarter_id')->constrained('headquarters');
            $table->string('indoor_location')->comment('Obrigatório.');
            $table->float('quantity')->comment('Obrigatório.');
            $table->float('stock_alert_at')->nullable()->comment('Campo responsável por alertar quando o estoque entrar em zona para reposição.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_locations');
    }
};
