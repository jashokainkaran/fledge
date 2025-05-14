<?php
// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// existing “get /user” route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// YOUR CV-SCAN endpoint
Route::middleware('auth:sanctum')
     ->post('/profile/cv-scan', [ProfileController::class, 'scanCv']);
