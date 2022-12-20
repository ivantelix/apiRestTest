<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CharactersController;

Route::controller(CharactersController::class)->group(function () {
    Route::get('/characters', 'index');
    Route::get('/character/search', 'search');
    Route::post('/character/create', 'create');
    Route::put('/character/update/{id}', 'update');
    Route::put('/character/remove/{id}', 'remove');
});