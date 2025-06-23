<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
    use HasFactory;

    protected $table = 'prestadores';

    protected $fillable = [
        'nome',
        'logradouro',
        'bairro',
        'numero',
        'latitude',
        'longitude',
        'cidade',
        'UF',
        'situacao',
    ];

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'servico_prestador')
            ->withPivot(['km_saida', 'valor_saida', 'valor_km_excedente', 'status'])
            ->withTimestamps();
    }
}
