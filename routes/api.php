<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('positions', PositionController::class);
});

