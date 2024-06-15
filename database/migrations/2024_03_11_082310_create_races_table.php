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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->comment('ID do usuário que está fazendo a corrida (o motorista no caso).');
            $table->foreignId('headquarter_id')->references('id')->on('headquarters')->comment('ID de qual unidade da CO2 Peças está sendo efetuada aquela corrida como ponto de partida.');
            $table->foreignId('vehicle_id')->references('id')->on('vehicles')->comment('Sinalizando o veículo utilizado.');
            $table->timestamp('arrival_time')->nullable()->comment('Campo simbolizando a chegada do  motorista de determinada corrida.');
            $table->text('observation')->nullable();
            $table->enum('status', ['EM ANDAMENTO', 'CONCLUÍDA']);
            $table->float('total_distance')->nullable()->comment('Soma de todas as distâncias das paradas efetuadas na corrida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};
