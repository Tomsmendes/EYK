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
use App\Http\Controllers\OfensivaController;    
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\ComunidadeController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostCommentController;

// Página inicial
Route::get('/', function () { return view('home'); })->name('home');

// Autenticação
Route::get('/logar', fn() => view('Site.tipo.auth.login'))->name('login');
Route::get('/registrar', fn() => view('Site.tipo.auth.register'))->name('register');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// ==========================
// CURSOS
// ==========================
Route::prefix('cursos')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/{curso}', [CursoController::class, 'show'])->name('cursos.show');
    
    // Rotas apenas para professores e admin
    Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
        Route::get('/create', [CursoController::class, 'create'])->name('cursos.create');
        Route::post('/', [CursoController::class, 'store'])->name('cursos.store');
        Route::get('/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
        Route::put('/{curso}', [CursoController::class, 'update'])->name('cursos.update');
        Route::delete('/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');
    });

    // ==========================
    // AULAS ANINHADAS EM CURSOS
    // ==========================
    Route::prefix('{curso}/aulas')->group(function () {
        Route::get('/', [AulaController::class, 'indexByCurso'])->name('cursos.aulas.index');
        
        // Rotas apenas para professores e admin
        Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
            Route::get('/create', [AulaController::class, 'create'])->name('cursos.aulas.create');
            Route::post('/', [AulaController::class, 'store'])->name('cursos.aulas.store');
        });
        
        // ==========================
        // MATERIAIS ANINHADOS EM AULAS
        // ==========================
        Route::prefix('{aula}/materiais')->group(function () {
            Route::get('/', [MaterialController::class, 'indexByAula'])->name('cursos.aulas.materiais.index');
            Route::get('/{material}', [MaterialController::class, 'show'])->name('cursos.aulas.materiais.show');
            Route::get('/{material}/download', [MaterialController::class, 'download'])->name('cursos.aulas.materiais.download');
            
            // Rotas apenas para professores e admin
            Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
                Route::get('/create', [MaterialController::class, 'create'])->name('cursos.aulas.materiais.create');
                Route::post('/', [MaterialController::class, 'store'])->name('cursos.aulas.materiais.store');
                Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('cursos.aulas.materiais.edit');
                Route::put('/{material}', [MaterialController::class, 'update'])->name('cursos.aulas.materiais.update');
                Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('cursos.aulas.materiais.destroy');
            });
        });
    });
});

// ==========================
// AULAS INDEPENDENTES
// ==========================
Route::prefix('aulas')->group(function () {
    Route::get('/', [AulaController::class, 'indexNonNested'])->name('aulas.index');
    Route::get('/{aula}', [AulaController::class, 'show'])->name('aulas.show');
    
    // Rotas apenas para professores e admin
    Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
        Route::get('/{aula}/edit', [AulaController::class, 'edit'])->name('aulas.edit');
        Route::put('/{aula}', [AulaController::class, 'update'])->name('aulas.update');
        Route::delete('/{aula}', [AulaController::class, 'destroy'])->name('aulas.destroy');
    });
});

// ==========================
// MATERIAIS INDEPENDENTES (para compatibilidade)
// ==========================
Route::prefix('materiais')->group(function () {
    Route::get('/', [MaterialController::class, 'index'])->name('materiais.index');
    Route::get('/{material}', [MaterialController::class, 'show'])->name('materiais.show');
    Route::get('/{material}/download', [MaterialController::class, 'download'])->name('materiais.download');
    
    // Rotas apenas para professores e admin
    Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
        Route::get('/create', [MaterialController::class, 'create'])->name('materiais.create');
        Route::post('/', [MaterialController::class, 'store'])->name('materiais.store');
        Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('materiais.edit');
        Route::put('/{material}', [MaterialController::class, 'update'])->name('materiais.update');
        Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('materiais.destroy');
    });
});

// ==========================
// VÍDEOS
// ==========================
Route::prefix('videos')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/{video}', [VideoController::class, 'show'])->name('videos.show');
    
    // Rotas apenas para professores e admin
    Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
        Route::get('/create', [VideoController::class, 'create'])->name('videos.create');
        Route::post('/', [VideoController::class, 'store'])->name('videos.store');
        Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
        Route::put('/{video}', [VideoController::class, 'update'])->name('videos.update');
        Route::delete('/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
    });
});

// Página pública de vídeos
Route::get('/biblioteca', [VideoController::class, 'publicIndex'])->name('videos.public');

// ==========================
// QUESTIONÁRIOS
// ==========================
Route::prefix('questionarios')->group(function () {
    Route::get('/', [QuestionarioController::class, 'index'])->name('questionarios.index');
    Route::get('/{questionario}', [QuestionarioController::class, 'show'])->name('questionarios.show');
    
    // Rotas apenas para professores e admin
    Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
        Route::get('/create', [QuestionarioController::class, 'create'])->name('questionarios.create');
        Route::post('/', [QuestionarioController::class, 'store'])->name('questionarios.store');
        Route::get('/{questionario}/edit', [QuestionarioController::class, 'edit'])->name('questionarios.edit');
        Route::put('/{questionario}', [QuestionarioController::class, 'update'])->name('questionarios.update');
        Route::delete('/{questionario}', [QuestionarioController::class, 'destroy'])->name('questionarios.destroy');
    });
});

// ==========================
// PERGUNTAS
// ==========================
Route::prefix('perguntas')->group(function () {
    Route::get('/', [PerguntaController::class, 'index'])->name('perguntas.index');
    Route::get('/{pergunta}', [PerguntaController::class, 'show'])->name('perguntas.show');
    
    // Rotas apenas para professores e admin
    Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
        Route::get('/create', [PerguntaController::class, 'create'])->name('perguntas.create');
        Route::post('/', [PerguntaController::class, 'store'])->name('perguntas.store');
        Route::get('/{pergunta}/edit', [PerguntaController::class, 'edit'])->name('perguntas.edit');
        Route::put('/{pergunta}', [PerguntaController::class, 'update'])->name('perguntas.update');
        Route::delete('/{pergunta}', [PerguntaController::class, 'destroy'])->name('perguntas.destroy');
    });
});

// ==========================
// RESPOSTAS
// ==========================
Route::prefix('respostas')->group(function () {
    Route::get('/', [RespostaController::class, 'index'])->name('respostas.index');
    Route::get('/{resposta}', [RespostaController::class, 'show'])->name('respostas.show');
    
    // Rotas apenas para professores e admin
    Route::middleware(['auth', 'restrict.type:admin,prof'])->group(function () {
        Route::get('/create', [RespostaController::class, 'create'])->name('respostas.create');
        Route::post('/', [RespostaController::class, 'store'])->name('respostas.store');
        Route::get('/{resposta}/edit', [RespostaController::class, 'edit'])->name('respostas.edit');
        Route::put('/{resposta}', [RespostaController::class, 'update'])->name('respostas.update');
        Route::delete('/{resposta}', [RespostaController::class, 'destroy'])->name('respostas.destroy');
    });
});

// ==========================
// COMUNIDADE (acesso para todos os tipos logados)
// ==========================
Route::get('/comunidade', [ComunidadeController::class, 'index'])->name('comunidade');
Route::middleware(['auth', 'restrict.type:admin,prof,aluno'])->group(function () {
    Route::post('/comunidade', [ComunidadeController::class, 'store'])->name('comunidade.store');
    Route::post('/comunidade/post/{id}/curtir', [PostLikeController::class, 'curtir'])->name('post.curtir');
    Route::post('/comunidade/post/{id}/comentar', [PostCommentController::class, 'comentar'])->name('post.comentar');
});

// ==========================
// ADMIN (apenas admin)
// ==========================
Route::middleware(['auth', 'restrict.type:admin'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::prefix('ofensivas')->group(function () {
        Route::get('/', [OfensivaController::class, 'index'])->name('ofensivas.index');
        Route::get('/create', [OfensivaController::class, 'create'])->name('ofensivas.create');
        Route::post('/', [OfensivaController::class, 'store'])->name('ofensivas.store');
        Route::get('/{ofensiva}', [OfensivaController::class, 'show'])->name('ofensivas.show');
        Route::get('/{ofensiva}/edit', [OfensivaController::class, 'edit'])->name('ofensivas.edit');
        Route::put('/{ofensiva}', [OfensivaController::class, 'update'])->name('ofensivas.update');
        Route::delete('/{ofensiva}', [OfensivaController::class, 'destroy'])->name('ofensivas.destroy');
    });

    Route::prefix('faqs')->group(function () {
        Route::get('/', [FaqsController::class, 'index'])->name('faqs.index');
        Route::get('/create', [FaqsController::class, 'create'])->name('faqs.create');
        Route::post('/', [FaqsController::class, 'store'])->name('faqs.store');
        Route::get('/{faq}', [FaqsController::class, 'show'])->name('faqs.show');
        Route::get('/{faq}/edit', [FaqsController::class, 'edit'])->name('faqs.edit');
        Route::put('/{faq}', [FaqsController::class, 'update'])->name('faqs.update');
        Route::delete('/{faq}', [FaqsController::class, 'destroy'])->name('faqs.destroy');
    });
});

// Página de acesso não autorizado
Route::get('/unauthorized', fn() => 'Usuário Não Autorizado!')->name('unauthorized');