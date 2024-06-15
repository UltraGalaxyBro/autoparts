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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('set null')->comment('Coluna responsável em referenciar o vendedor que montou a cotação.');
            $table->foreignId('customer_id')->nullable()->references('id')->on('customers')->onDelete('set null');
            $table->timestamp('validity')->comment('Coluna responsável em definir até quando (data limite) tal cotação ficará disponível.');
            $table->enum('payment_method', ['PIX', 'BOLETO', 'CARTÃO DE CRÉDITO', 'CHEQUE']);
            $table->string('payment_details_bol')->nullable()->comment('Intervalo de dias entre cada boleto faturado.');
            $table->string('payment_details_credit')->nullable()->comment('Parcelas máximas aceitas.');
            $table->enum('freight_type', ['CIF', 'FOB', 'RETIRADA EM LOJA']);
            $table->decimal('freight_price', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('expenses', 8, 2)->nullable()->comment('Coluna simbolizando caso haja alguma despesa de qualquer natureza que deseja incluir');
            $table->decimal('total_price', 8, 2)->nullable();
            $table->string('chassis_number')->nullable()->comment('Chassi do veículo se preferir informar');
            $table->text('observation')->nullable();
            $table->enum('status', ['AGUARDANDO RESPOSTA', 'EM ANDAMENTO', 'CONCLUÍDA', 'VENDIDA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
