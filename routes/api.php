<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

// Public
Route::post("/login", [AuthController::class, "login"]);

// Protected
Route::middleware("auth:sanctum")->group(function () {
    Route::get("/profile", [AuthController::class, "profile"]);
    Route::post("/logout", [AuthController::class, "logout"]);

    Route::apiResource("customers", CustomerController::class);
    Route::apiResource("products", ProductController::class);
});