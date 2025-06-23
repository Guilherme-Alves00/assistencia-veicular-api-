<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use Illuminate\Http\Request;

class BuscaPrestadorController extends Controller
{
    /**
     * Busca prestadores online associados a um serviço específico,
     * calcula a distância total da rota (prestador → origem → destino → prestador)
     * e retorna a lista ordenada por menor distância com os custos estimados.
     */
    public function buscar(Request $request)
    {
        $id_servico = $request->input('id_servico');
        $origem = $request->input('origem');
        $destino = $request->input('destino');

        // Filtra prestadores com o serviço solicitado e status 'online'
        $prestadores = Prestador::whereHas('servicos', function ($query) use ($id_servico) {
            $query->where('servico_id', $id_servico)
                ->where('servico_prestador.status', 'online');
        })
            ->with(['servicos' => function ($query) use ($id_servico) {
                $query->where('servico_id', $id_servico)
                    ->withPivot(['km_saida', 'valor_saida', 'valor_km_excedente', 'status']);
            }])
            ->get();

        $dados = [];

        foreach ($prestadores as $prestador) {
            $pivot = $prestador->servicos->first()?->pivot;

            // Calcula distâncias entre os pontos da rota
            $d1 = $this->calcularDistanciaEmKm($prestador->latitude, $prestador->longitude, $origem['latitude'], $origem['longitude']);
            $d2 = $this->calcularDistanciaEmKm($origem['latitude'], $origem['longitude'], $destino['latitude'], $destino['longitude']);
            $d3 = $this->calcularDistanciaEmKm($destino['latitude'], $destino['longitude'], $prestador->latitude, $prestador->longitude);
            $distancia = $d1 + $d2 + $d3;

            // Calcula valor total com base na distância excedente
            $km_excedente = max(0, $distancia - $pivot->km_saida);
            $valor_total = $pivot->valor_saida + ($km_excedente * $pivot->valor_km_excedente);

            $dados[] = [
                'id' => $prestador->id,
                'nome' => $prestador->nome,
                'cidade' => $prestador->cidade,
                'distancia_total_km' => round($distancia, 2),
                'valor_total' => round($valor_total, 2),
                'status' => $pivot->status
            ];
        }

        // Ordena os prestadores por distância crescente
        usort($dados, fn($a, $b) => $a['distancia_total_km'] <=> $b['distancia_total_km']);

        return response()->json([
            'quantidade' => count($dados),
            'dados' => $dados
        ]);
    }

    /**
     * Calcula a distância em quilômetros entre dois pontos geográficos usando a fórmula de Haversine.
     */
    private function calcularDistanciaEmKm($lat1, $lon1, $lat2, $lon2)
    {
        $raioTerra = 6371; // km

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        return $raioTerra * $c;
    }
}
