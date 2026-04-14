<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marca extends Model
{
    use HasFactory;

    // Importante: numero, ano, desenho_vetor (o JSON) e foto_path
    protected $fillable = [
        'produtor_id',
        'municipio_id',
        'numero',
        'ano',
        'qtd_tracos',
        'proporcao',
        'centro_x',
        'centro_y',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5',
        'q6',
        'q7',
        'q8',
        'q9',
        'desenho_vetor',
        'foto_path'
    ];

    // Dizemos ao Laravel que o desenho_vetor deve ser tratado como array/json automaticamente
    protected $casts = [
        'desenho_vetor' => 'array',
        'qtd_tracos' => 'integer',
    ];

    public function produtor(): BelongsTo
    {
        return $this->belongsTo(Produtor::class);
    }

    // Os sócios adicionais
    public function socios()
    {
        return $this->belongsToMany(Produtor::class, 'marca_produtor')
            ->withPivot('tipo_vinculo')
            ->withTimestamps();
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }
}
