<?php

use Illuminate\Support\Facades\Route;

// Rota para visualizar se a aplicação está rodando corretamente
Route::get('/', function () {
    return view('welcome');
});
