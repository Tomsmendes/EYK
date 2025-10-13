@extends('Site.tipo.layouts.home')

@section('title', 'Adicionar Material')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white text-center py-3 rounded-top-4" 
                     style="background: linear-gradient(90deg, #b8860b, #ffd700);">
                    <h3 class="mb-0 fw-bold">📁 Adicionar Material</h3>
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

                    <form action="{{ route('materiais.store', [$curso, $aula]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Aula ID oculto -->
                        <input type="hidden" name="aula_id" value="{{ $aula->id }}">

                        <!-- Nome do Material -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Nome do Material:</label>
                            <input type="text" class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   name="mt_name" placeholder="Digite o nome do material" required>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Descrição:</label>
                            <textarea class="form-control rounded-3 shadow-sm border-warning" 
                                      name="mt_descricao" rows="3" placeholder="Descreva o material"></textarea>
                        </div>

                        <!-- Arquivo -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Arquivo:</label>
                            <input type="file" class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   name="url" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.zip,.rar" required>
                            <small class="text-muted">Formatos permitidos: PDF, DOC, DOCX, PPT, PPTX, TXT, ZIP, RAR (Max: 2MB)</small>
                        </div>

                        <!-- Botão -->
                        <div class="text-center mt-4">
                            <button type="submit" 
                                    class="btn btn-lg px-5 shadow-sm rounded-3 text-dark fw-bold"
                                    style="background: linear-gradient(90deg, #ffd700, #b8860b); border: none;">
                                <i class="bi bi-upload"></i> Adicionar Material
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center bg-light rounded-bottom-4 py-3">
                    <small class="text-muted">O material será adicionado à aula 
                        <strong>{{ $aula->title }}</strong> do curso 
                        <strong>{{ $curso->name_curso }}</strong>.
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection