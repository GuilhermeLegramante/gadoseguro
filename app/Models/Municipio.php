<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'departamento_nome',
        'prazo_validade_anos',
        'orgao_cnpj',
        'orgao_endereco',
        'orgao_telefone',
        'brasao_path',
        'numero_automatico',
    ];

    public function produtores(): HasMany
    {
        return $this->hasMany(Produtor::class);
    }

    public function marcas(): HasMany
    {
        return $this->hasMany(Marca::class);
    }
}
