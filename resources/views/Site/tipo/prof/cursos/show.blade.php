@extends('Site.tipo.layouts.home')

@section('title', 'Detalhes do Curso')

@section('content')
<div class="container mt-5">
    <h1 class="text-center fw-bold mb-4" style="color: gold;">{{ $curso->name_curso }}</h1>

    @if (session('success'))
        <div class="alert alert-success text-center fw-semibold" style="background-color: #fff8e1; color: #c79a00; border: 1px solid gold;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <img src="{{ asset('Uploads/cursos/' . $curso->thumbnail) }}"
             class="card-img-top rounded-top"
             alt="{{ $curso->name_curso }}"
             style="height: 320px; object-fit: cover; border-bottom: 4px solid gold;">

        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="text-muted mb-0">Criado por: {{ $curso->user_name ?? 'Administrador' }}</h5>
            <div>
                <a href="{{ route('cursos.edit', $curso->id) }}" 
                   class="btn fw-bold text-white me-2" 
                   style="background-color: gold; border-radius: 25px;">
                    Editar
                </a>
                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger fw-bold rounded-5"
                            onclick="return confirm('Tem certeza que deseja excluir este curso?')">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h3 class="fw-bold" style="color: gold;">Descrição do Curso</h3>
            <p class="text-muted">{{ $curso->description }}</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold" style="color: gold;">Conteúdos do Curso</h3>
                {{-- Botão para criar nova aula --}}
                <a href="{{ route('cursos.aulas.create', $curso) }}" 
                   class="btn fw-bold text-white" 
                   style="background-color: gold; border-radius: 25px;">Nova Aula</a>
                </a>
            </div>

            @forelse ($curso->aulas->sortBy('order') as $aula)
                <div class="card mb-3 border-0 shadow-sm rounded-4">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #b8860b, #ffd700); color: white; border-radius: 10px 10px 0 0;">

                        <h5 class="mb-0 fw-bold">{{ $aula->title }}</h5>

                        <div class="d-flex gap-2">
                            <a href="{{ route('videos.create', ['aula_id' => $aula->id]) }}" class="btn text-white fw-semibold"  style="background-color: #b8860b; border: none; border-radius: 25px;">
                                + Vídeo
                            </a>
                           <a  href="{{ route('cursos.aulas.materiais.create', [$curso, $aula]) }}" 
                            class="btn text-white fw-semibold" 
                            style="background-color: #b8860b; border: none; border-radius: 25px;">
                                + PDF
                            </a>
                        </div>
                    </div>


                    <div class="card-body">
                        <p class="text-muted">{{ $aula->description }}</p>

                        <!-- Accordion -->
                        <div class="accordion" id="accordion-{{ $aula->id }}">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header" id="heading-{{ $aula->id }}">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $aula->id }}">
                                        Ver Detalhes
                                    </button>
                                </h2>
                                <div id="collapse-{{ $aula->id }}" class="accordion-collapse collapse">
                                    <div class="accordion-body">

                                        <h6 class="fw-bold mt-2" style="color: gold;">Vídeos</h6>
                                        @if ($aula->videos->count() > 0)
                                            <div class="row">
                                                @foreach ($aula->videos as $video)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card shadow-sm border-0 rounded-4">
                                                            <img src="{{ asset('storage/' . $video->caminho_thumbnail) }}"
                                                                alt="{{ $video->titulo }}"
                                                                class="card-img-top"
                                                                style="height: 200px; object-fit: cover; border-bottom: 3px solid gold;">

                                                            <div class="card-body text-center">
                                                                <h5 class="fw-bold text-dark">{{ $video->titulo }}</h5>

                                                                <div class="d-flex justify-content-center gap-2 mt-2">
                                                                    <!-- Botão Assistir -->
                                                                    <a href="{{ route('videos.show', $video) }}"
                                                                    class="btn fw-bold text-white"
                                                                    style="background-color: #b8860b; border-radius: 25px;">
                                                                        ▶ Assistir
                                                                    </a>

                                                                    <!-- Botão Excluir -->
                                                                    <form action="{{ route('videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este vídeo?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                                class="btn fw-bold text-white"
                                                                                style="background-color: #8b7500; border-radius: 25px;">
                                                                            🗑 Excluir
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Nenhum vídeo disponível.</p>
                                        @endif


                                        <!-- SEÇÃO DE MATERIAIS MELHORADA -->
                                        <div class="mt-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="fw-bold mb-0" style="color: gold;">
                                                    <i class="bi bi-folder-fill me-2"></i>Materiais ({{ $aula->materials->count() }})
                                                </h6>
                                            </div>
                                            
                                            @if ($aula->materials->count() > 0)
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body p-0">
                                                        @foreach ($aula->materials as $material)
                                                            <div class="d-flex justify-content-between align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                                <div class="d-flex align-items-center">
                                                                    @php
                                                                        $extension = pathinfo($material->url, PATHINFO_EXTENSION);
                                                                        $icon = 'bi-file-earmark-text';
                                                                        $color = 'text-primary';
                                                                        
                                                                        switch($extension) {
                                                                            case 'pdf': $icon = 'bi-file-earmark-pdf'; $color = 'text-danger'; break;
                                                                            case 'doc': case 'docx': $icon = 'bi-file-earmark-word'; $color = 'text-primary'; break;
                                                                            case 'ppt': case 'pptx': $icon = 'bi-file-earmark-ppt'; $color = 'text-warning'; break;
                                                                            case 'zip': case 'rar': $icon = 'bi-file-earmark-zip'; $color = 'text-secondary'; break;
                                                                            default: $icon = 'bi-file-earmark-text'; $color = 'text-muted';
                                                                        }
                                                                    @endphp
                                                                    
                                                                    <i class="bi {{ $icon }} {{ $color }} fs-5 me-3"></i>
                                                                    <div>
                                                                        <h6 class="mb-0 fw-semibold">{{ $material->mt_name }}</h6>
                                                                        <small class="text-muted">{{ strtoupper($extension) }} • {{ $material->created_at->format('d/m/Y') }}</small>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="d-flex gap-1">
                                                                    <!-- Botão Ver -->
                                                                    <a href="{{ route('materiais.show', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                                                                       class="btn btn-outline-warning btn-sm rounded-3"
                                                                       title="Ver detalhes">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                    
                                                                    <!-- Botão Download -->
                                                                    <a href="{{ route('materiais.download', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                                                                    class="btn btn-warning btn-sm rounded-3 text-dark fw-semibold"
                                                                       download
                                                                       title="Baixar arquivo">
                                                                        <i class="bi bi-download"></i>
                                                                    </a>

                                                                    <!-- Botão Excluir -->
                                                                    <form action="{{ route('materiais.destroy', ['curso' => $curso->id, 'aula' => $aula->id, 'material' => $material->id]) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" 
                                                                                class="btn btn-outline-danger btn-sm rounded-3"
                                                                                title="Excluir material"
                                                                                onclick="return confirm('Tem certeza que deseja excluir este material?')">
                                                                            <i class="bi bi-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center py-3 bg-light rounded-3">
                                                    <i class="bi bi-folder-x fs-4 text-muted mb-2"></i>
                                                    <p class="text-muted mb-0">Nenhum material cadastrado</p>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- FIM SEÇÃO MATERIAIS -->

                                        <h6 class="fw-bold mt-4" style="color: gold;">Questionários</h6>
                                        @if ($aula->questionarios->count() > 0)
                                            <ul class="list-group list-group-flush">
                                                @foreach ($aula->questionarios as $questionario)
                                                    <li class="list-group-item">{{ $questionario->title }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">Nenhum questionário disponível.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center">Nenhuma aula disponível.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Adicionar Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    .accordion-button:not(.collapsed) {
        background-color: #fff8e1;
        color: #b8860b;
        border-color: gold;
    }
    
    .accordion-button:focus {
        border-color: gold;
        box-shadow: 0 0 0 0.25rem rgba(184, 134, 11, 0.25);
    }
    
    .btn-group .btn {
        margin: 0 2px;
    }
</style>

<script>
    // Inicializar tooltips do Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection