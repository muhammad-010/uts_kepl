<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;

// Public
Route::post("/login", [AuthController::class, "login"]);

// Protected
Route::middleware("auth:sanctum")->group(function () {
    Route::get("/profile", [AuthController::class, "profile"]);
    Route::post("/logout", [AuthController::class, "logout"]);

    Route::apiResource("customers", CustomerController::class);
    Route::apiResource("products", ProductController::class);
    Route::apiResource("categories", CategoryController::class);
    Route::apiResource("suppliers", SupplierController::class);
});