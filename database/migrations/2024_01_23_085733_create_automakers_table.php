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
        Schema::create('automakers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shard_code')->unique()->comment('Coluna que compõe o "inside_code" presente na tabela "products".');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automakers');
    }
};
