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
        Schema::table('produtores', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nome');
            $table->string('genero', 20)->nullable()->after('email'); // Masculino, Feminino, Outro
            $table->date('data_nascimento')->nullable()->after('genero');
            $table->string('inscricao_estadual')->nullable()->after('cpf_cnpj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtores', function (Blueprint $table) {
            $table->dropColumn(['email', 'genero', 'data_nascimento', 'inscricao_estadual']);
        });
    }
};
