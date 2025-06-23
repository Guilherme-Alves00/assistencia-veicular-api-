<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * Autentica o usuário com e-mail e senha e retorna um token JWT válido.
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    /**
     * Retorna os dados do usuário autenticado via token.
     */
    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    /**
     * Invalida o token atual, realizando logout.
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
     * Gera um novo token a partir de um token ainda válido (refresh token).
     */
    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => JWTAuth::factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error'    => 'Erro ao renovar o token',
                'mensagem' => $e->getMessage()
            ], 401);
        }
    }
}
