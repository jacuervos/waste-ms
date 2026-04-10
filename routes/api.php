<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeWasteController;
use App\Http\Controllers\OrderTypeWasteController;

Route::prefix('typeWaste')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::apiResource('type-wastes', TypeWasteController::class);
        Route::patch('type-wastes/{typeWaste}/toggle-status', [TypeWasteController::class, 'toggleStatus']);
        Route::apiResource('order-type-wastes', OrderTypeWasteController::class);
    });
});
