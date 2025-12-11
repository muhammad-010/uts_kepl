<?php

/**
 * Vercel Serverless Function Entry Point
 * 
 * This file serves as the entry point for Laravel API
 * when deployed on Vercel as a serverless function.
 */

// Change to project root directory
chdir(__DIR__ . '/..');

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
