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
        Schema::create('race_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->references('id')->on('races')->onDelete('cascade');
            $table->string('name')->comment('Diz respeito sobre o nome do local onde aconteceu a parada.');
            $table->float('latitude');
            $table->float('longitude');
            $table->float('distance')->comment('Distância percorrida desde o último ponto até esta parada (EM QUILÔMETROS).');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_stops');
    }
};
