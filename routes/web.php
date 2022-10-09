<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Companies/Index');
})->middleware(['auth', 'verified'])->name('home');

require __DIR__.'/auth.php';
