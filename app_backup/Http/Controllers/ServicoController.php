<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;

class ServicoController extends Controller
{
    /**
     * Retorna todos os serviços com situação 'ativo'.
     */
    public function index()
    {
        return response()->json([
            'dados' => Servico::where('situacao', 'ativo')->get()
        ]);
    }
}
