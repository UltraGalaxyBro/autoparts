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
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained('budgets')->onDelete('cascade');
            $table->string('description')->comment('Nome/descrição do produto');
            $table->foreignId('supplier_id')->comment('Fornecedor sobre tal produto');
            $table->string('supplier_reference')->nullable()->comment('Referência (geralmente um código) sobre como achar tal produto no fornecedor.');
            $table->decimal('cost', 8, 2);
            $table->integer('deadline')->comment('O prazo é em base de dias úteis');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_items');
    }
};
