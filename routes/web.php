<?php

use App\Http\Controllers\front\ContactController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\PostController;
use App\Http\Controllers\front\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('front.home');

Route::get('/noticias', [PostController::class, 'index'])->name('front.posts.index');
Route::get('/noticias/{slug}', [PostController::class, 'show'])->name('front.posts.show');

Route::get('/contacto', [ContactController::class, 'index'])->name('front.contact');
Route::post('/contacto', [ContactController::class, 'store'])->name('front.contact.store');

Route::get('/{path}', [SectionController::class, 'show'])
    ->where('path', '.*')
    ->name('front.section');
