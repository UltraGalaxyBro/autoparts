<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*Migration para adicionar tabels que futuramnete serão necessários na implementação da API dos Correios*/
    public function up(): void
    {
        //Caso algo seja alterado nesta migration, lembre-se de adaptar também a Rule de correios. Assim não irá atrapalhar na validação
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('height', 8, 2)->after('description')->nullable()->comment('Lógica deste campo sendo em centímetros (cm).');
            $table->decimal('width', 8, 2)->after('height')->nullable()->comment('Lógica deste campo sendo em centímetros (cm).');
            $table->decimal('lenght', 8, 2)->after('width')->nullable()->comment('Lógica deste campo sendo em centímetros (cm).');
            $table->decimal('weight', 8, 2)->after('lenght')->nullable()->comment('Lógica deste campo sendo em quilos (kg).');
            $table->enum('freight', ['SÓ RETIRADA', 'CORREIOS', 'TRANSPORTADORA'])->nullable()->after('weight')->comment('Tipo de frete.');
            $table->enum('packaging', ['CAIXA', 'PLÁSTICO/ROLO', 'ENVELOPE', 'CAIXOTE', 'NÃO POSSUI'])->nullable()->after('freight')->comment('Tipo da embalagem recomendado para envio em frete.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('height');
            $table->dropColumn('width');
            $table->dropColumn('lenght');
            $table->dropColumn('weight');
            $table->dropColumn('packaging');
        });
    }
};
