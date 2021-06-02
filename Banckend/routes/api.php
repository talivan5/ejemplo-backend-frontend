<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('personas',[PersonaController::class,'index'])->name('personas.index');
Route::post('personas',[PersonaController::class,'store']);
Route::get('personas/{id}',[PersonaController::class,'show']);
Route::put('personas/{id}',[PersonaController::class,'update']);
Route::delete('personas/{id}',[PersonaController::class,'destroy']);