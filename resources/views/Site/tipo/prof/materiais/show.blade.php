@extends('Site.tipo.layouts.home')

@section('title', $material->mt_name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white d-flex justify-content-between align-items-center py-3 rounded-top-4" 
                     style="background: linear-gradient(90deg, #b8860b, #ffd700);">
                    <h3 class="mb-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        {{ $material->mt_name }}
                    </h3>
                    <div class="d-flex gap-2">
                        @if(pathinfo($material->url, PATHINFO_EXTENSION) === 'pdf')
                            <a href="{{ route('materiais.download', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                               class="btn btn-light btn-sm fw-bold text-dark rounded-3">
                                <i class="bi bi-download"></i> Baixar PDF
                            </a>
                        @else
                            <a href="{{ route('materiais.download', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                               class="btn btn-light btn-sm fw-bold text-dark rounded-3">
                                <i class="bi bi-download"></i> Baixar
                            </a>
                        @endif
                        <a href="{{ route('materiais.index') }}" 
                           class="btn btn-outline-light btn-sm fw-bold rounded-3">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if (session('success'))
                        <div class="alert alert-success m-4 rounded-3 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger m-4 rounded-3 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Visualizador de PDF (apenas para arquivos PDF) -->
                    @if(pathinfo($material->url, PATHINFO_EXTENSION) === 'pdf')
                    <div class="border-bottom">
                        <div class="p-4">
                            <h5 class="fw-bold text-warning mb-3">
                                <i class="bi bi-eye-fill me-2"></i>Visualização do PDF
                            </h5>
                            <div class="pdf-viewer-container rounded-3 border" style="height: 70vh; background: #f8f9fa;">
                                <iframe 
                                    src="{{ Storage::disk('public')->url($material->url) }}#toolbar=1&view=FitH" 
                                    width="100%" 
                                    height="100%" 
                                    frameborder="0"
                                    style="border-radius: 0.5rem;"
                                    id="pdfViewer"
                                >
                                    <div class="text-center py-5">
                                        <i class="bi bi-exclamation-triangle fs-1 text-warning mb-3"></i>
                                        <h5>Seu navegador não suporta a visualização de PDF</h5>
                                        <p class="text-muted">Clique no botão abaixo para baixar o arquivo</p>
                                        <a href="{{ route('materiais.download', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                                           class="btn btn-warning text-dark fw-bold rounded-3">
                                            <i class="bi bi-download"></i> Baixar PDF
                                        </a>
                                    </div>
                                </iframe>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="p-4">
                        <!-- Informações do Material -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold text-warning">
                                    <i class="bi bi-info-circle me-2"></i>Informações do Material
                                </h5>
                                <div class="ps-3">
                                    <p class="mb-2">
                                        <strong>Nome:</strong> 
                                        <span class="text-dark">{{ $material->mt_name }}</span>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Descrição:</strong> 
                                        <span class="text-dark">{{ $material->mt_descricao ?? 'Nenhuma descrição fornecida' }}</span>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Tipo:</strong> 
                                        <span class="badge bg-warning text-dark">{{ strtoupper(pathinfo($material->url, PATHINFO_EXTENSION)) }}</span>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Data de Criação:</strong> 
                                        <span class="text-dark">{{ $material->created_at->format('d/m/Y H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-warning">
                                    <i class="bi bi-journals me-2"></i>Informações da Aula
                                </h5>
                                <div class="ps-3">
                                    <p class="mb-2">
                                        <strong>Aula:</strong> 
                                        <span class="text-dark">{{ $material->aula->title }}</span>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Curso:</strong> 
                                        <span class="text-dark">{{ $material->aula->curso->name_curso ?? 'Curso não encontrado' }}</span>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Arquivo:</strong> 
                                        <span class="text-muted small">{{ basename($material->url) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Arquivo -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-warning mb-3">
                                <i class="bi bi-paperclip me-2"></i>Arquivo
                            </h5>
                            <div class="d-flex align-items-center p-3 bg-light rounded-3 shadow-sm">
                                @php
                                    $extension = pathinfo($material->url, PATHINFO_EXTENSION);
                                    $icon = 'bi-file-earmark-text';
                                    $color = 'text-warning';
                                    
                                    switch($extension) {
                                        case 'pdf': $icon = 'bi-file-earmark-pdf'; $color = 'text-danger'; break;
                                        case 'doc': case 'docx': $icon = 'bi-file-earmark-word'; $color = 'text-primary'; break;
                                        case 'ppt': case 'pptx': $icon = 'bi-file-earmark-ppt'; $color = 'text-warning'; break;
                                        case 'zip': case 'rar': $icon = 'bi-file-earmark-zip'; $color = 'text-secondary'; break;
                                        default: $icon = 'bi-file-earmark-text'; $color = 'text-warning';
                                    }
                                @endphp
                                
                                <i class="bi {{ $icon }} {{ $color }} fs-1 me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-dark">{{ $material->mt_name }}</h6>
                                    <small class="text-muted">{{ basename($material->url) }} • {{ strtoupper($extension) }} • {{ $material->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('materiais.download', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                                       class="btn btn-warning text-dark fw-bold rounded-3 shadow-sm">
                                        <i class="bi bi-download"></i> Baixar
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('materiais.index') }}" 
                                   class="btn btn-outline-warning rounded-3 shadow-sm fw-bold">
                                    <i class="bi bi-arrow-left"></i> Voltar para Materiais
                                </a>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('materiais.edit', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                                   class="btn btn-warning text-dark rounded-3 shadow-sm fw-bold">
                                    <i class="bi bi-pencil"></i> Editar Material
                                </a>
                                
                                <form action="{{ route('materiais.destroy', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger rounded-3 shadow-sm fw-bold"
                                            onclick="return confirm('Tem certeza que deseja excluir este material?')">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adicionar Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    .pdf-viewer-container {
        background: #f8f9fa;
        position: relative;
    }
    
    .pdf-viewer-container.loading::before {
        content: "Carregando PDF...";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #6c757d;
        font-weight: 500;
    }
    
    .badge {
        font-size: 0.75em;
        padding: 0.35em 0.65em;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pdfViewer = document.getElementById('pdfViewer');
        const pdfContainer = document.querySelector('.pdf-viewer-container');
        
        if (pdfViewer && pdfContainer) {
            // Mostrar loading
            pdfContainer.classList.add('loading');
            
            pdfViewer.onload = function() {
                pdfContainer.classList.remove('loading');
            };
            
            // Fallback se o PDF não carregar
            setTimeout(function() {
                if (pdfContainer.classList.contains('loading')) {
                    pdfContainer.classList.remove('loading');
                    pdfContainer.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-exclamation-triangle fs-1 text-warning mb-3"></i>
                            <h5>Erro ao carregar o PDF</h5>
                            <p class="text-muted">O PDF pode estar indisponível ou corrompido.</p>
                            <a href="{{ route('materiais.download', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                               class="btn btn-warning text-dark fw-bold rounded-3">
                                <i class="bi bi-download"></i> Baixar PDF
                            </a>
                        </div>
                    `;
                }
            }, 10000); // 10 segundos de timeout
        }
    });
</script>
@endsection