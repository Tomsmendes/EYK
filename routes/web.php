<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuestionarioController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\OfensivaController;
use App\Http\Controllers\FaqsController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

// Páginas de autenticação
Route::get('/', function () {
    return view('Site.auth.login');
})->name('login');

// Processamento de formulários
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

/*
|--------------------------------------------------------------------------
| Rotas de Usuário
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Rotas para gestão de usuários
Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.all');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
});

/*
|--------------------------------------------------------------------------
| Rotas de Administração
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Gestão de Conteúdos
    Route::resource('cursos', CursoController::class);
    Route::resource('aulas', AulaController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('materiais', MaterialController::class);
    
    // Gestão de Questionários
    Route::resource('questionarios', QuestionarioController::class);
    Route::resource('perguntas', PerguntaController::class);
    Route::resource('respostas', RespostaController::class);
    
    // Outros recursos
    Route::resource('funcoes', FuncaoController::class);
    Route::resource('ofensivas', OfensivaController::class);
    Route::resource('faqs', FaqsController::class);
});