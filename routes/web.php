<?php

use App\Http\Controllers\funcaocontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Videocontroller;
use Illuminate\Contracts\View\View;


Route::get('/', [UserController::class, 'home'])->name('home');

Route::prefix('users')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->where('id', '[0-9]+')->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->where('id', '[0-9]+')->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+')->name('users.delete');
});

Route::prefix('funcoes')->group(function(){
    Route::get('/', [funcaocontroller::class, 'index'])->name('funcoes.index');
    Route::get('/create', [funcaocontroller::class, 'create'])->name('funcoes.create');
    Route::post('/', [funcaocontroller::class, 'store'])->name('funcoes.store');
    Route::get('/{id}/edit', [funcaocontroller::class, 'edit'])->where('id', '[0-9]+')->name('funcoes.edit');
    Route::put('/{id}', [funcaocontroller::class, 'update'])->where('id', '[0-9]+')->name('funcoes.update');
    Route::delete('/{id}', [funcaocontroller::class, 'destroy'])->where('id', '[0-9]+')->name('funcoes.delete');
});

Route::prefix('videos')->group(function(){
    Route::get('/', [Videocontroller::class, 'index'])->name('videos.index');
    Route::get('/create', [Videocontroller::class, 'create'])->name('videos.create');
    Route::post('/', [Videocontroller::class, 'store'])->name('videos.store');
    Route::get('/{id}/edit', [Videocontroller::class, 'edit'])->where('id', '[0-9]+')->name('videos.edit');
    Route::put('/{id}', [Videocontroller::class, 'update'])->where('id', '[0-9]+')->name('videos.update');
    Route::delete('/{id}', [Videocontroller::class, 'destroy'])->where('id', '[0-9]+')->name('videos.delete');
});


Route::fallback(function(){
    return "Tomás Tens Erros na Rota";
});

