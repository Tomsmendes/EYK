@extends('Site.tipo.layouts.home')

@section('title', 'Criar Nova Aula')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white text-center py-3 rounded-top-4" 
                     style="background: linear-gradient(90deg, #b8860b, #ffd700);">
                    <h3 class="mb-0 fw-bold">📘 Criar Nova Aula - {{ $curso->name_curso }}</h3>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success text-center rounded-3 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- CORREÇÃO: Usar a rota aninhada passando o curso --}}
                    <form action="{{ route('cursos.aulas.store', $curso) }}" method="POST">
                        @csrf

                        <!-- Curso ID oculto -->
                        <input type="hidden" name="curso_id" value="{{ $curso->id }}">

                        <!-- Título -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Título da Aula:</label>
                            <input type="text" class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   name="title" value="{{ old('title') }}" placeholder="Digite o título da aula" required>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Descrição:</label>
                            <textarea class="form-control rounded-3 shadow-sm border-warning" 
                                      name="description" rows="3" placeholder="Descreva o conteúdo da aula">{{ old('description') }}</textarea>
                        </div>

                        <!-- Botões -->
                        <div class="text-center mt-4">
                            <button type="submit" 
                                    class="btn btn-lg px-5 shadow-sm rounded-3 text-dark fw-bold"
                                    style="background: linear-gradient(90deg, #ffd700, #b8860b); border: none;">
                                <i class="bi bi-plus-circle"></i> Criar Aula
                            </button>
                            
                            <a href="{{ route('cursos.show', $curso) }}" 
                               class="btn btn-lg px-5 shadow-sm rounded-3 btn-outline-secondary ms-2">
                                <i class="bi bi-arrow-left"></i> Voltar ao Curso
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center bg-light rounded-bottom-4 py-3">
                    <small class="text-muted">
                        A aula será criada dentro do curso <strong>{{ $curso->name_curso }}</strong>.
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection