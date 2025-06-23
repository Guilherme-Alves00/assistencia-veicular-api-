<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrestadorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'logradouro' => $this->logradouro,
            'bairro' => $this->bairro,
            'numero' => $this->numero,
            'cidade' => $this->cidade,
            'UF' => $this->UF,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'situacao' => $this->situacao,
            'servicos' => $this->servicos->map(function ($servico) {
                return [
                    'id' => $servico->id,
                    'nome' => $servico->nome,
                    'km_saida' => $servico->pivot->km_saida,
                    'valor_saida' => $servico->pivot->valor_saida,
                    'valor_km_excedente' => $servico->pivot->valor_km_excedente,
                ];
            }),
        ];
    }
}
