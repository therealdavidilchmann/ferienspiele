<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/after', [App\Http\Controllers\AfterController::class, 'index'])->name('after');
Route::get('/organizer', [App\Http\Controllers\OrganizerController::class, 'index'])->name('organizer');
Route::get('/mfz', [App\Http\Controllers\MfzController::class, 'index'])->name('mfz');
Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');

Route::get('/fs-register', [App\Http\Controllers\FerienspieleController::class, 'register'])->name('fs-register');
Route::post('/fs-register', [App\Http\Controllers\FerienspieleController::class, 'register'])->name('fs-register');
