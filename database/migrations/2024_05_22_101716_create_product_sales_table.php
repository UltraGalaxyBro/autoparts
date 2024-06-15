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
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->comment('Coluna crucial visto que o propósito é monitorar os produtos EM ESTOQUE');
            $table->foreignId('headquarter_id')->constrained('headquarters')->onDelete('cascade')->comment('Auxiliar para especificar de onde que houve a venda do produto.');
            $table->enum('sale_mode', ['DENTRO E-COMMERCE', 'FORA E-COMMERCE']);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Caso a venda tenha o valor sale_mode igual a DENTRO E-COMMERCE, interprete que este campo é referente a um cliente. Caso seja o outro valor, então refere-se ao vendedor. É necessário ser assim devido às regras de negócio.');
            $table->float('quantity_sold')->comment('Obrigatório.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sales');
    }
};
