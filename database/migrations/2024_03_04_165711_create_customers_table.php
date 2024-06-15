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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('customer_level_id')->nullable()->constrained('customer_levels')->onDelete('set null');
            $table->string('telephone')->nullable();
            $table->string('celphone');
            $table->enum('whatsapp', ['Sim', 'Não']);
            $table->enum('type_buyer', ['PF', 'PJ']);
            $table->string('cpf')->nullable()->unique()->comment('Dado que pode ser nulo ou não a depender da resposta do "type_buyer".');
            $table->string('company')->nullable()->comment('Dado que pode ser nulo ou não a depender da resposta do "type_buyer". Se trata do nome fantasia da empresa do comprador.');
            $table->string('cnpj')->nullable()->comment('Dado que pode ser nulo ou não a depender da resposta do "type_buyer".');
            $table->string('ie')->nullable()->comment('Dado que pode ser nulo ou não a depender da resposta do "type_buyer".');
            $table->decimal('purchases', 10, 2)->nullable()->comment('Compras feitas com sucesso pelo cliente.');
            $table->timestamp('last_purchase_at')->nullable()->comment('Data da última compra feita pelo cliente.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
