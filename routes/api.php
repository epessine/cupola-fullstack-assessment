<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/cities', [CityController::class, 'index'])->name('companies.index');
Route::get('/states', [StateController::class, 'index'])->name('companies.index');
