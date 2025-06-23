<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnderecoController extends Controller
{
    /**
     * Consulta as coordenadas (latitude e longitude) de um endereço,
     * utilizando uma API externa protegida por autenticação básica.
     */
    public function buscarCoordenadas(Request $request)
    {
        $endereco = $request->query('endereco');

        if (!$endereco) {
            return response()->json(['erro' => 'Endereço é obrigatório.'], 400);
        }

        $usuario = env('API_USUARIO');
        $senha = env('API_SENHA');

        try {
            $resposta = Http::withBasicAuth($usuario, $senha)
                ->get("https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/endereco/geocode/" . urlencode($endereco));

            if ($resposta->successful()) {
                $dados = $resposta->json();

                return response()->json([
                    'latitude' => $dados['latitude'] ?? null,
                    'longitude' => $dados['longitude'] ?? null,
                    'status' => 'sucesso',
                ]);
            }

            return response()->json([
                'erro' => 'Não foi possível consultar as coordenadas.',
                'status_code' => $resposta->status(),
            ], $resposta->status());
        } catch (\Exception $e) {
            return response()->json([
                'erro' => 'Erro interno ao consultar coordenadas.',
                'detalhes' => $e->getMessage(),
            ], 500);
        }
    }
}
