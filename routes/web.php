<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\FaqsController;
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

Route::prefix('cursos')->group(function(){
    Route::get('/', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/create', [CursoController::class, 'create'])->name('cursos.create');
    Route::post('/', [CursoController::class, 'store'])->name('cursos.store');
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->where('id', '[0-9]+')->name('cursos.edit');
    Route::put('/{id}', [CursoController::class, 'update'])->where('id', '[0-9]+')->name('cursos.update');
    Route::delete('/{id}', [CursoController::class, 'destroy'])->where('id', '[0-9]+')->name('cursos.delete');
});

Route::prefix('faqs')->group(function(){
    Route::get('/', [FaqsController::class, 'index'])->name('faqs.index');
    Route::get('/create', [FaqsController::class, 'create'])->name('faqs.create');
    Route::post('/', [FaqsController::class, 'store'])->name('faqs.store');
    Route::get('/{id}/edit', [FaqsController::class, 'edit'])->where('id', '[0-9]+')->name('faqs.edit');
    Route::put('/{id}', [FaqsController::class, 'update'])->where('id', '[0-9]+')->name('faqs.update');
    Route::delete('/{id}', [FaqsController::class, 'destroy'])->where('id', '[0-9]+')->name('faqs.delete');
});


Route::fallback(function(){
    return "Tomás Tens Erros na Rota";
});

