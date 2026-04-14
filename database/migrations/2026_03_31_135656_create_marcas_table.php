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
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produtor_id')->constrained('produtores');
            $table->foreignId('municipio_id')->constrained('municipios');
            $table->integer('numero');
            $table->integer('ano');
            $table->text('desenho_vetor')->nullable(); // Para a busca inteligente
            $table->string('foto_path')->nullable();   // Caminho da foto real
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};
