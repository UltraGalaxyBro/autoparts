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
        Schema::table('product_withdrawals', function (Blueprint $table) {
            $table->string('required_by')->after('quantity')->nullable()->comment('Campo para mostrar quem solicitou essa retirada ao sinalizar uma venda manual do estoque.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_withdrawals', function (Blueprint $table) {
            $table->dropColumn('required_by');
        });
    }
};
