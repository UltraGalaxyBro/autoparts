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
        Schema::create('product_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('headquarter_id')->constrained('headquarters')->onDelete('cascade');
            $table->string('indoor_location')->comment('Obrigatório.');
            $table->float('quantity')->comment('Obrigatório.');
            $table->enum('withdrawal_status', ['PENDENTE', 'CONCLUÍDA']);
            $table->string('completed_by')->nullable()->comment('Campo para mostrar quem concluir essa solicitação de retirada do produto do estoque.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_withdrawals');
    }
};
