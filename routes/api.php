<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderTypeWasteController;

Route::middleware('auth.jwt')->group(function () {

    // TypeWaste — solo accesible por el rol Administrador
    Route::middleware('role:Administrador')->group(function () {
        Route::post('type-wastes', '\App\Http\Controllers\TypeWasteStoreController@create')->name('typeWaste.create');
        Route::put('type-wastes/{typeWaste}', '\App\Http\Controllers\TypeWasteUpdateController@update')->name('typeWaste.update');
        Route::patch('type-wastes/{typeWaste}/toggle-status', '\App\Http\Controllers\TypeWasteChangeStateController@toggleStatus')->name('typeWaste.toggleStatus');
        Route::delete('type-wastes/{typeWaste}', '\App\Http\Controllers\TypeWasteDeleteController@delete')->name('typeWaste.delete');
    });

    // TypeWaste — accesible por cualquier usuario autenticado
    Route::get('type-wastes', '\App\Http\Controllers\TypeWasteIndexController@index')->name('typeWaste.index');
    Route::get('type-wastes/active', '\App\Http\Controllers\TypeWasteIndexController@active')->name('typeWaste.active');

    // OrderTypeWaste
    Route::apiResource('order-type-wastes', OrderTypeWasteController::class);
});

