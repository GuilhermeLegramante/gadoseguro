<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produtor;
use App\Models\Municipio;

class ProdutorSeeder extends Seeder
{
    public function run(): void
    {
        // Pegamos todos os municípios que inseriste anteriormente
        $municipios = Municipio::all();

        if ($municipios->isEmpty()) {
            $this->command->error("Primeiro deves rodar o MunicipioSeeder!");
            return;
        }

        foreach ($municipios as $municipio) {
            // Criamos 2 produtores de exemplo para cada cidade da tua lista
            Produtor::create([
                'municipio_id' => $municipio->id,
                'nome'         => 'Estância ' . $municipio->nome . ' Rural',
                'cpf_cnpj'     => rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-00',
                'telefone'     => '(55) 9' . rand(8000, 9999) . '-' . rand(1000, 9999),
            ]);

            Produtor::create([
                'municipio_id' => $municipio->id,
                'nome'         => 'João da Silva - ' . $municipio->nome,
                'cpf_cnpj'     => rand(10, 99) . '.' . rand(100, 999) . '.' . rand(100, 999) . '/0001-01',
                'telefone'     => '(55) 9' . rand(8000, 9999) . '-' . rand(1000, 9999),
            ]);
        }
    }
}
