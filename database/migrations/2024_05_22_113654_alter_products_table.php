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
        //Caso algo seja alterado nesta migration, lembre-se de adaptar também a Rule de correios. Assim não irá atrapalhar na validação
        Schema::table('products', function (Blueprint $table) {
            $table->string('ncm')->after('price')->nullable()->comment('Por enquanto, por regras de negócio, deixar como opcional.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('ncm');
        });
    }
};
