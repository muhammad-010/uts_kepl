<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect('/login'); });
Route::view('/login', 'login')->name('login');
Route::view('/dashboard', 'dashboard')->name('dashboard');