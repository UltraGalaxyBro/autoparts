<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('headquarter_id')->nullable()->constrained('headquarters')->onDelete('set null')->comment('Simboliza onde o usuário trabalha quando, claro, o mesmo não tiver a função de Cliente estabelecida nas permissions. Ou seja, destinado aos funcionários da empresa. Será nulo quando o usuário se tratar de um cliente.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['headquarter_id']);
            $table->dropColumn('headquarter_id');
        });
    }
};
