<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produtor extends Model
{
    use HasFactory;

    protected $table = 'produtores'; // Força o Laravel a usar este nome

    // Adicione os novos campos ao $fillable
    protected $fillable = [
        'nome',
        'email',
        'genero',
        'data_nascimento',
        'cpf_cnpj',
        'inscricao_estadual'
    ];

    // Relacionamento 1 para 1 com Endereço
    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function marcas(): HasMany
    {
        return $this->hasMany(Marca::class);
    }

    public function sociedades()
    {
        return $this->belongsToMany(Marca::class, 'marca_produtor');
    }
}
