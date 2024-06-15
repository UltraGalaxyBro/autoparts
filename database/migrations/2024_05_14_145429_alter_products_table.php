<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sells');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('sells')->nullable()->after('extra_img2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sells');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('sells', 10, 2)->nullable()->after('extra_img2');
        });
    }
};
