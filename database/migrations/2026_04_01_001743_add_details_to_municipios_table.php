<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('municipios', function (Blueprint $table) {
            $table->string('departamento_nome')->nullable()->after('nome');
            $table->integer('prazo_validade_anos')->default(10)->after('departamento_nome');
            $table->string('orgao_cnpj')->nullable()->after('prazo_validade_anos');
            $table->string('orgao_endereco')->nullable()->after('orgao_cnpj');
            $table->string('orgao_telefone')->nullable()->after('orgao_endereco');
            $table->string('brasao_path')->nullable()->after('orgao_telefone');
            $table->boolean('numero_automatico')->default(true)->after('brasao_path');
        });
    }

    public function down()
    {
        Schema::table('municipios', function (Blueprint $table) {
            $table->dropColumn([
                'departamento_nome',
                'prazo_validade_anos',
                'orgao_cnpj',
                'orgao_endereco',
                'orgao_telefone',
                'brasao_path',
                'numero_automatico',
            ]);
        });
    }
};
