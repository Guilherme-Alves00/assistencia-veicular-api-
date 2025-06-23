<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeocodeController extends Controller
{
    /**
     * Consulta latitude e longitude de um endereço via API externa,
     * tratando diferentes formatos no retorno da resposta.
     */
    public function buscarCoordenadas($endereco)
    {
        $enderecoCodificado = urlencode($endereco);

        $url = "https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/endereco/geocode/{$enderecoCodificado}";

        $response = Http::withBasicAuth(
            'teste-Infornet',
            'c@nsulta-dad0s-ap1-teste-Infornet#24'
        )->get($url);

        if ($response->successful()) {
            $json = $response->json();

            return response()->json([
                'latitude' => $json['lat'] ?? $json['latitude'] ?? $json['data']['latitude'] ?? null,
                'longitude' => $json['lon'] ?? $json['longitude'] ?? $json['data']['longitude'] ?? null
            ]);
        }

        return response()->json([
            'erro' => 'Endereço não encontrado ou falha na consulta.'
        ], $response->status());
    }
}
