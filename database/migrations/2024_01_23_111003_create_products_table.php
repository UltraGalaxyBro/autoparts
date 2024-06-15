<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('automaker_id')->constrained('automakers');
            $table->string('original_code')->nullable();
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('brand_code')->nullable()->unique();
            $table->enum('condition', ['Novo', 'Seminovo']);
            $table->enum('measure', ['UNID','KG','LT']);
            $table->decimal('cost', 8, 2);
            $table->decimal('price', 8, 2);
            $table->enum('visible', ['Sim', 'Não']);
            $table->enum('sale', ['Sim', 'Não'])->comment('Disponível somente quando a visiblidade do produto for SIM');
            $table->decimal('sale_price', 8, 2)->nullable()->comment('Disponível e obrigatório quando a promoção for SIM');
            $table->date('sale_period_until')->nullable()->comment('Disponível e obrigatório quando a promoção for SIM');
            $table->text('aplication')->nullable()->comment('Disponível e obrigatório somente quando a visiblidade do produto for SIM');
            $table->text('description')->nullable()->comment('Disponível somente quando a visiblidade do produto for SIM');
            $table->string('keywords')->comment('Formado com as junções das informações do produto quando houver o cadastro.');
            $table->string('inside_code')->comment('Formado com a ajuda dos códigos fragementados presentes nas tabelas categorias e montadoras');
            $table->string('main_img')->default('default-image.png');
            $table->string('extra_img')->default('default-image.png');
            $table->string('extra_img2')->default('default-image.png');
            $table->decimal('sells', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
