@extends('Site.tipo.layouts.home')

@section('title', 'Detalhes do Curso')

@section('content')
<div class="container mt-5">
    <h1 class="text-center fw-bold mb-4">{{ $curso->description }}</h1>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('cursos.index') }}" class="btn btn-primary">Voltar</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="card mb-4 position-relative">
        <img src="{{ asset('Uploads/cursos/' . $curso->thumbnail) }}" class="card-img-top" alt="{{ $curso->description }}" style="height: 300px; object-fit: cover;">
        <div class="position-absolute top-0 start-0 p-3 text-white bg-dark bg-opacity-75">
            <h2 class="mb-1">{{ $curso->description }}</h2>
            <p class="mb-1">Duração: {{ $curso->duration }} min</p>
            <p class="mb-0">Avaliação: {{ number_format($curso->rating ?? 0, 1) }} ★★★★☆ ({{ $curso->reviews ?? 0 }})</p>
        </div>
        <div class="card-body d-flex justify-content-end gap-2">
            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-warning text-white">Editar</a>
            <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Descrição do Curso</h3>
            <p class="card-text">
                {{ $curso->description }} é uma excelente oportunidade para iniciantes que desejam dominar o violão. Com uma duração total de {{ $curso->duration }} minutos, ele proporciona uma experiência de aprendizado completa.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Conteúdos do Curso</h3>
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#createAulaModal">
                    <i class="bi bi-plus-lg"></i> Adicionar Nova Aula
                </button>
            </div>
            <h4>Aulas</h4>
            @forelse ($curso->aulas->sortBy('order') as $aula)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $aula->title }}</h5>
                        <p class="card-text"><strong>Descrição:</strong> {{ $aula->description }}</p>
                        <p class="card-text"><strong>Duração Total:</strong> 
                            @php
                                $totalDuration = $aula->videos->sum('duration') ?? 0;
                            @endphp
                            {{ $totalDuration }} min
                        </p>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createVideoModal-{{ $aula->id }}" {{ $aula->videos->count() > 0 ? 'disabled' : '' }}>
                                Adicionar Vídeo
                            </button>
                        </div>

                        <!-- Detalhes da Aula -->
                        <div class="accordion" id="accordion-{{ $aula->id }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $aula->id }}" aria-expanded="false" aria-controls="collapse-{{ $aula->id }}">
                                        Ver Detalhes
                                    </button>
                                </h2>
                                <div id="collapse-{{ $aula->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion-{{ $aula->id }}">
                                    <div class="accordion-body">
                                        <!-- Vídeos -->
                                        @if ($aula->videos->count() > 0)
                                            <h6>Vídeos</h6>
                                            <ul class="list-group list-group-flush">
                                                @foreach ($aula->videos as $video)
                                                    <li class="list-group-item">
                                                        {{ $video->vd_name }} - {{ $video->duration }} min
                                                        @if ($video->vd_descricao)
                                                            <br><small class="text-muted">{{ $video->vd_descricao }}</small>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">Nenhum vídeo disponível.</p>
                                        @endif

                                        <!-- Materiais -->
                                        @if ($aula->materials->count() > 0)
                                            <h6>Materiais</h6>
                                            <ul class="list-group list-group-flush mt-2">
                                                @foreach ($aula->materials as $material)
                                                    <li class="list-group-item">
                                                        {{ $material->mt_name }} ({{ $material->type }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">Nenhum material disponível.</p>
                                        @endif

                                        <!-- Questionários -->
                                        @if ($aula->questionarios->count() > 0)
                                            <h6>Questionários</h6>
                                            <ul class="list-group list-group-flush mt-2">
                                                @foreach ($aula->questionarios as $questionario)
                                                    <li class="list-group-item">
                                                        {{ $questionario->title }}
                                                    </li>
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

                <!-- Modal para Criar Vídeo -->
                <div class="modal fade" id="createVideoModal-{{ $aula->id }}" tabindex="-1" aria-labelledby="createVideoModalLabel-{{ $aula->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createVideoModalLabel-{{ $aula->id }}">Adicionar Vídeo para {{ $aula->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('videos.store', $aula->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="vd_name-{{ $aula->id }}" class="form-label">Nome do Vídeo</label>
                                        <input type="text" class="form-control" id="vd_name-{{ $aula->id }}" name="vd_name" value="{{ old('vd_name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="vd_descricao-{{ $aula->id }}" class="form-label">Descrição do Vídeo (Opcional)</label>
                                        <textarea class="form-control" id="vd_descricao-{{ $aula->id }}" name="vd_descricao" rows="4">{{ old('vd_descricao') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="duration-{{ $aula->id }}" class="form-label">Duração (minutos)</label>
                                        <input type="number" class="form-control" id="duration-{{ $aula->id }}" name="duration" value="{{ old('duration') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="video_file-{{ $aula->id }}" class="form-label">Arquivo de Vídeo</label>
                                        <input type="file" class="form-control" id="video_file-{{ $aula->id }}" name="video_file" accept="video/*" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Salvar Vídeo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">Nenhuma aula disponível.</div>
            @endforelse
        </div>
    </div>

    <!-- Modal para Criar Aula -->
    <div class="modal fade" id="createAulaModal" tabindex="-1" aria-labelledby="createAulaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAulaModalLabel">Adicionar Nova Aula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('aulas.store', $curso->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="title" class="form-label">Título da Aula</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="order" class="form-label">Ordem</label>
                            <input type="number" class="form-control" id="order" name="order" value="{{ old('order') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Aula</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection