<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use Illuminate\Http\JsonResponse;

class PrestadorController extends Controller
{
    /**
     * Retorna todos os prestadores com seus serviços associados.
     */
    public function index(): JsonResponse
    {
        $prestadores = Prestador::with('servicos')->get();

        return response()->json($prestadores);
    }
}
