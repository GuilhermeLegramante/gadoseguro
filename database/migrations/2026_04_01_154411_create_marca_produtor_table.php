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
        Schema::create('marca_produtor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id')->constrained()->onDelete('cascade');
            $table->foreignId('produtor_id')->constrained('produtores')->onDelete('cascade');
            $table->string('tipo_vinculo')->default('Sócio'); // Ex: Sócio, Arrendatário, Esposa(o)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marca_produtor');
    }
};
