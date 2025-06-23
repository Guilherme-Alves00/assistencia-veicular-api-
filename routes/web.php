<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/consultar-prestadores', function () {
    return view('consultar-prestadores');
});
