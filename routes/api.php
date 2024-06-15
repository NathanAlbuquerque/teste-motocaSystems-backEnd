<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::resource('categorias', CategoriaController::class)->except('create', 'edit');
Route::resource('produtos', ProdutoController::class)->except('create', 'edit');
