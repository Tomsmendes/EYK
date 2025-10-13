@extends('Site.tipo.layouts.home')

@section('title', 'Editar Material')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white text-center py-3 rounded-top-4" 
                     style="background: linear-gradient(90deg, #b8860b, #ffd700);">
                    <h3 class="mb-0 fw-bold">✏️ Editar Material</h3>
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

                    <form action="{{ route('materiais.update', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Aula ID oculto -->
                        <input type="hidden" name="aula_id" value="{{ $aula->id }}">

                        <!-- Nome do Material -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Nome do Material:</label>
                            <input type="text" class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   name="mt_name" value="{{ old('mt_name', $material->mt_name) }}" required>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Descrição:</label>
                            <textarea class="form-control rounded-3 shadow-sm border-warning" 
                                      name="mt_descricao" rows="3">{{ old('mt_descricao', $material->mt_descricao) }}</textarea>
                        </div>

                        <!-- Arquivo Atual -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Arquivo Atual:</label>
                            <div class="alert alert-info rounded-3">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                {{ basename($material->url) }}
                                <a href="{{ Storage::disk('public')->url($material->url) }}" 
                                   class="btn btn-sm btn-outline-warning ms-2" download>
                                    <i class="bi bi-download"></i> Baixar
                                </a>
                            </div>
                        </div>

                        <!-- Novo Arquivo -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Substituir Arquivo (opcional):</label>
                            <input type="file" class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   name="url" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.zip,.rar">
                            <small class="text-muted">Deixe em branco para manter o arquivo atual</small>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('materiais.show', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                               class="btn btn-outline-warning rounded-3 shadow-sm fw-bold">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            
                            <button type="submit" 
                                    class="btn btn-lg px-5 shadow-sm rounded-3 text-dark fw-bold"
                                    style="background: linear-gradient(90deg, #ffd700, #b8860b); border: none;">
                                <i class="bi bi-check-circle"></i> Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection