<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return Cliente::all();
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable|string',
        ]);

        $cliente = Cliente::create($dados);

        return response()->json($cliente, 201);
    }

    public function show(Cliente $cliente)
    {
        return $cliente;
    }

    public function update(Request $request, Cliente $cliente)
    {
        $dados = $request->validate([
            'nome' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'nullable|string',
        ]);

        $cliente->update($dados);

        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(null, 204);
    }
}
