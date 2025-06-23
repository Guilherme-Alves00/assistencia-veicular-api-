<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prestadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('numero');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('cidade');
            $table->string('UF');
            $table->enum('situacao', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestadores');
    }
};
