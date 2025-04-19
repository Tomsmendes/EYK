<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuestionarioController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FuncaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->group(function () {
    // Rotas para Cursos
    Route::resource('cursos', CursoController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Aulas (aninhadas)
    Route::resource('aulas', AulaController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Vídeos (aninhadas)
    Route::resource('videos', VideoController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Materiais (aninhadas)
    Route::resource('materiais', MaterialController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Questionários (aninhadas)
    Route::resource('questionarios', QuestionarioController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Perguntas (aninhadas)
    Route::resource('perguntas', PerguntaController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Respostas (aninhadas)
    Route::resource('respostas', RespostaController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Usuários
    Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rotas para Funções
    Route::resource('funcoes', FuncaoController::class)->only(['index', 'store', 'update', 'destroy']);

});

Route::get('/', function () {
    return view('home');
})->name('home');