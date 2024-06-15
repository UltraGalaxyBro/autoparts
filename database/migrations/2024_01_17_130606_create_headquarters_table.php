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
        Schema::create('headquarters', function (Blueprint $table) {
            $table->id();
            $table->enum('visible', ['Sim','Não']);
            $table->string('name');
            $table->string('zip_code');
            $table->string('state');
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('telephone');
            $table->string('whatsapp');
            $table->string('map')->comment('Campo para o link de localização no Google Maps');
            $table->string('coordinates')->comment('Puramente para auxiliar no rastreio do motorista');
            $table->string('main_img')->default('default-image.png')->comment('Imagem da fachada da unidade, por exemplo.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headquarters');
    }
};
