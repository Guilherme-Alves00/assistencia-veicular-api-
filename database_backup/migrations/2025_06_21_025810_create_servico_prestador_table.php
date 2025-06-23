<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('servico_prestador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prestador_id');
            $table->unsignedBigInteger('servico_id');
            $table->decimal('km_saida', 8, 2)->nullable();
            $table->decimal('valor_saida', 10, 2)->nullable();
            $table->decimal('valor_km_excedente', 10, 2)->nullable(); // 👈 Adicionado agora
            $table->string('status')->default('offline');
            $table->timestamps();

            $table->foreign('prestador_id')->references('id')->on('prestadores')->onDelete('cascade');
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servico_prestador');
    }
};
