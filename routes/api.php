<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BuscaPrestadorController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\GeocodeController;

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/buscar-prestadores', [BuscaPrestadorController::class, 'buscar']);
    Route::get('/servicos', [ServicoController::class, 'index']);
    Route::get('/endereco/geocode/{endereco}', [GeocodeController::class, 'buscarCoordenadas']);
});