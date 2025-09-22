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
use App\Http\Controllers\ComunidadeController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostCommentController;

Route::prefix('curso')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/{curso}/sho', [CursoController::class, 'show'])->name('cursos.show');
    Route::get('/create', [CursoController::class, 'create'])->name('cursos.create');
    Route::post('/', [CursoController::class, 'store'])->name('cursos.store');
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
    Route::put('/curso/{curso}', [CursoController::class, 'update'])->name('user.update');
    Route::delete('/{id}', [CursoController::class, 'delete'])->where('id', '[0-9]+')->name('cursos.destroy');
});


Route::resource('aulas', AulaController::class);
Route::resource('videos', VideoController::class);
Route::resource('materiais', MaterialController::class);
Route::resource('questionarios', QuestionarioController::class);
Route::resource('perguntas', PerguntaController::class);
Route::resource('respostas', RespostaController::class);

Route::get('/logar', function () { return view('Site.auth.login'); })->name('login');

Route::get('/registrar', function () { return view('Site.auth.register'); })->name('register');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/', function () { return view('home'); })->name('home');

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/comunidade', [ComunidadeController::class, 'index'])->name('comunidade');

Route::middleware(['auth', 'restrict.type:admin'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.all');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{id}', [UserController::class, 'delete'])->where('id', '[0-9]+')->name('user.delete');
    });
    Route::resource('ofensivas', OfensivaController::class);
    Route::resource('faqs', FaqsController::class);
});

Route::middleware(['auth', 'restrict.type:aluno'])->group(function () {

});

Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {

});

Route::middleware(['auth', 'restrict.type:admin,prof,aluno'])->group(function () {
    Route::post('/comunidade', [ComunidadeController::class, 'store'])->name('comunidade.store');
    Route::post('/comunidade/post/{id}/curtir', [PostLikeController::class, 'curtir'])->name('post.curtir');
    Route::post('/comunidade/post/{id}/comentar', [PostCommentController::class, 'comentar'])->name('post.comentar');
});

Route::get('/unauthorized', function () { return ('Usuario Não Autorizado!'); })->name('unauthorized');


Route::middleware(['auth'])->group(function () {
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
});

// Página pública de vídeos (todos podem ver)
Route::get('/biblioteca', [VideoController::class, 'publicIndex'])->name('videos.public');
