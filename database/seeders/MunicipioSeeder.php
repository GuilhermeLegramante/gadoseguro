<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipioSeeder extends Seeder
{
    public function run(): void
    {
        $cidades = [
            'Aceguá',
            'Cacequi',
            'Lavras do Sul',
            'Maçambará',
            'Manoel Viana',
            'Mata',
            'Nova Esperança do Sul',
            'Santo Antônio das Missões',
            'São Francisco de Assis',
            'São Sepé',
            'São Vicente do Sul',
            'Santa Margarida do Sul',
            'Santa Vitória do Palmar',
            'Tupanciretã',
            'Unistalda',
            'Quaraí',
            'Jaguari',
            'Alegrete',
            'Bossoroca'
        ];

        foreach ($cidades as $cidade) {
            \App\Models\Municipio::create(['nome' => $cidade]);
        }
    }
}
