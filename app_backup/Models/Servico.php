<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function prestadores()
    {
        return $this->belongsToMany(Prestador::class, 'servico_prestador')
            ->withPivot(['km_saida', 'valor_saida', 'valor_km_excedente', 'status'])
            ->withTimestamps();
    }
}
