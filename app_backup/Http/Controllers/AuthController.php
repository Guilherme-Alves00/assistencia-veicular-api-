<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Autentica o usuário com base nas credenciais fornecidas e retorna um token JWT junto ao nome.
     */
    public function login(Request $request)
    {
        $credenciais = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credenciais)) {
            return response()->json(['erro' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'token' => $token,
            'nome' => Auth::user()->name,
        ]);
    }
}
