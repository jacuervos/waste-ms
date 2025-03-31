<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('typeWaste')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::apiResource('type-wastes', TypeWasteController::class);
        Route::apiResource('order-type-wastes', OrderTypeWasteController::class);
    });
});
