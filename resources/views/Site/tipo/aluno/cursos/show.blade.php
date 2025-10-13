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

    <!-- Banner do Curso -->
    <div class="card shadow-lg border-0 rounded-4 mb-4 overflow-hidden">
        <img src="{{ asset('Uploads/cursos/' . $curso->thumbnail) }}"
             class="card-img-top"
             alt="{{ $curso->name_curso }}"
             style="height: 400px; object-fit: cover;">
        
        <div class="card-body text-center py-4" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
            <h5 class="text-white mb-2">Criado por: {{ $curso->user_name ?? 'Administrador' }}</h5>
            <p class="text-gold mb-0">{{ $curso->category }}</p>
        </div>
    </div>

    <!-- Barra de Progresso do Curso -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-semibold mb-0" style="color: gold;">
                    <i class="bi bi-graph-up me-2"></i>Progresso do Curso
                </h5>
                <span id="progressPercentage" class="fw-bold fs-5" style="color: #b8860b;">0%</span>
            </div>
            <div class="progress" style="height: 12px; border-radius: 10px;">
                <div id="courseProgress" class="progress-bar" 
                     style="background: linear-gradient(90deg, #b8860b, #ffd700); transition: width 0.5s ease;"
                     role="progressbar" 
                     aria-valuenow="0" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>
            <small class="text-muted mt-2 d-block" id="progressText">
                Complete os vídeos em ordem sequencial para desbloquear o conteúdo
            </small>
        </div>
    </div>

    <!-- Descrição do Curso -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h3 class="fw-bold mb-3" style="color: gold;">
                <i class="bi bi-info-circle me-2"></i>Descrição do Curso
            </h3>
            <p class="text-muted fs-6">{{ $curso->description }}</p>
        </div>
    </div>

    <!-- Conteúdos do Curso -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="fw-bold mb-4" style="color: gold;">
                <i class="bi bi-collection-play me-2"></i>Conteúdos do Curso
            </h3>

            @php
                // Coletar todos os vídeos do curso em ordem
                $allCourseVideos = $curso->aulas->flatMap(function($aula) {
                    return $aula->videos->map(function($video) use ($aula) {
                        $video->aula_title = $aula->title;
                        return $video;
                    });
                })->sortBy('created_at')->values();
                
                $allMaterials = $curso->aulas->flatMap->materials;
                $allQuestionarios = $curso->aulas->flatMap->questionarios;
                
                // IDs dos vídeos para o JavaScript
                $videoIds = $allCourseVideos->pluck('id')->toArray();
            @endphp

            <!-- Grid de Vídeos -->
            @if ($allCourseVideos->count() > 0)
                <div class="mb-5">
                    <h4 class="fw-semibold mb-4 text-dark border-bottom pb-2">
                        <i class="bi bi-camera-video me-2" style="color: #b8860b;"></i>
                        Vídeos <span class="badge bg-warning text-dark ms-2">{{ $allCourseVideos->count() }}</span>
                    </h4>
                    <div class="row g-4">
                        @foreach ($allCourseVideos as $index => $video)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="video-item" 
                                     data-video-id="{{ $video->id }}" 
                                     data-video-order="{{ $index + 1 }}"
                                     data-locked="{{ $index > 0 ? 'true' : 'false' }}">
                                    
                                    @if($index > 0)
                                        <!-- Vídeo bloqueado -->
                                        <div class="card border-0 shadow-sm h-100 video-card locked-video" 
                                             style="cursor: not-allowed; position: relative;">
                                            <div class="locked-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center rounded-3"
                                                 style="background: rgba(0,0,0,0.7); z-index: 10;">
                                                <i class="bi bi-lock-fill text-warning fs-1"></i>
                                            </div>
                                    @else
                                        <!-- Primeiro vídeo sempre liberado -->
                                        <a href="{{ route('videos.show', $video) }}" class="text-decoration-none">
                                        <div class="card border-0 shadow-sm h-100 video-card" 
                                             style="cursor: pointer; transition: all 0.3s ease;">
                                    @endif
                                    
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $video->caminho_thumbnail) }}"
                                                     class="card-img-top {{ $index > 0 ? 'opacity-50' : '' }}"
                                                     alt="{{ $video->titulo }}"
                                                     style="height: 180px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 m-2">
                                                    <span class="badge bg-dark bg-opacity-75 fs-7">
                                                        <i class="bi bi-play-circle me-1"></i>{{ $index + 1 }}
                                                    </span>
                                                </div>
                                                <div class="position-absolute top-0 start-0 m-2">
                                                    @if($index === 0)
                                                        <span class="badge bg-success bg-opacity-75 fs-7">
                                                            <i class="bi bi-unlock me-1"></i>Liberado
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary bg-opacity-75 fs-7">
                                                            <i class="bi bi-lock me-1"></i>Bloqueado
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <div class="play-button">
                                                        <i class="bi bi-play-circle-fill fs-1 text-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title fw-semibold mb-2 {{ $index > 0 ? 'text-muted' : '' }}">
                                                    {{ $video->titulo }}
                                                </h6>
                                                <small class="text-muted mb-2">{{ $video->aula_title ?? 'Sem aula' }}</small>
                                                <div class="mt-auto">
                                                    @if($index > 0)
                                                        <button class="btn w-100 fw-bold text-white" 
                                                                style="background-color: #6c757d; border-radius: 10px; cursor: not-allowed;" 
                                                                disabled>
                                                            <i class="bi bi-lock me-2"></i>Bloqueado
                                                        </button>
                                                        <small class="text-warning mt-1 d-block">
                                                            Complete o vídeo anterior
                                                        </small>
                                                    @else
                                                        <a href="{{ route('videos.show', $video) }}"
                                                           class="btn w-100 fw-bold text-white"
                                                           style="background-color: #b8860b; border-radius: 10px;">
                                                            <i class="bi bi-play-fill me-2"></i>Assistir
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                    
                                    @if($index > 0)
                                        </div>
                                    @else
                                        </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Lista de Materiais -->
            @if ($allMaterials->count() > 0)
                <div class="mb-5">
                    <h4 class="fw-semibold mb-4 text-dark border-bottom pb-2">
                        <i class="bi bi-paperclip me-2" style="color: #b8860b;"></i>
                        Materiais <span class="badge bg-warning text-dark ms-2">{{ $allMaterials->count() }}</span>
                    </h4>
                    <div class="row g-3">
                        @foreach ($allMaterials as $material)
                            @php
                                $extension = pathinfo($material->url, PATHINFO_EXTENSION);
                                $icon = 'bi-file-earmark-text';
                                $color = 'text-primary';
                                $bgColor = 'bg-primary bg-opacity-10';
                                
                                switch($extension) {
                                    case 'pdf': $icon = 'bi-file-earmark-pdf'; $color = 'text-danger'; $bgColor = 'bg-danger bg-opacity-10'; break;
                                    case 'doc': case 'docx': $icon = 'bi-file-earmark-word'; $color = 'text-primary'; $bgColor = 'bg-primary bg-opacity-10'; break;
                                    case 'ppt': case 'pptx': $icon = 'bi-file-earmark-ppt'; $color = 'text-warning'; $bgColor = 'bg-warning bg-opacity-10'; break;
                                    case 'zip': case 'rar': $icon = 'bi-file-earmark-zip'; $color = 'text-secondary'; $bgColor = 'bg-secondary bg-opacity-10'; break;
                                    case 'xls': case 'xlsx': $icon = 'bi-file-earmark-excel'; $color = 'text-success'; $bgColor = 'bg-success bg-opacity-10'; break;
                                    default: $icon = 'bi-file-earmark-text'; $color = 'text-muted'; $bgColor = 'bg-light';
                                }
                            @endphp

                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100 material-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-3 p-3 {{ $bgColor }}">
                                                    <i class="bi {{ $icon }} {{ $color }} fs-4"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fw-semibold mb-1 text-truncate">{{ $material->mt_name }}</h6>
                                                <small class="text-muted d-block">{{ strtoupper($extension) }}</small>
                                                <small class="text-muted">{{ $material->created_at->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('materiais.show', ['curso' => $curso->id, 'aula' => $material->aula_id, 'material' => $material->id]) }}" 
                                               class="btn btn-outline-warning btn-sm flex-fill rounded-3">
                                                <i class="bi bi-eye me-1"></i>Ver
                                            </a>
                                            <a href="{{ route('materiais.download', ['curso' => $curso->id, 'aula' => $material->aula_id, 'material' => $material->id]) }}" 
                                               class="btn btn-warning btn-sm flex-fill rounded-3 text-dark fw-semibold"
                                               download>
                                                <i class="bi bi-download me-1"></i>Baixar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Questionários -->
            @if ($allQuestionarios->count() > 0)
                <div class="mb-4">
                    <h4 class="fw-semibold mb-4 text-dark border-bottom pb-2">
                        <i class="bi bi-clipboard-check me-2" style="color: #b8860b;"></i>
                        Questionários <span class="badge bg-warning text-dark ms-2">{{ $allQuestionarios->count() }}</span>
                    </h4>
                    <div class="row g-3">
                        @foreach ($allQuestionarios as $questionario)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100 quiz-card">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="bi bi-clipboard-check fs-1" style="color: #b8860b;"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-2">{{ $questionario->title }}</h6>
                                        <small class="text-muted mb-2 d-block">{{ $questionario->aula->title ?? 'Sem aula' }}</small>
                                        <p class="text-muted small mb-3">
                                            {{ $questionario->perguntas->count() }} pergunta(s)
                                        </p>
                                        <a href="{{ route('questionarios.show', $questionario) }}"
                                           class="btn w-100 fw-bold text-white"
                                           style="background-color: #b8860b; border-radius: 10px;">
                                            <i class="bi bi-pencil me-2"></i>Responder
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Mensagem quando não há conteúdos -->
            @if ($allCourseVideos->count() === 0 && $allMaterials->count() === 0 && $allQuestionarios->count() === 0)
                <div class="text-center py-5">
                    <i class="bi bi-collection-play fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum conteúdo disponível</h5>
                    <p class="text-muted">Este curso ainda não possui materiais.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Adicionar Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    .video-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .video-card:hover:not(.locked-video) {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(184, 134, 11, 0.3);
    }
    
    .material-card, .quiz-card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .material-card:hover, .quiz-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .play-button {
        opacity: 0;
        transition: all 0.3s ease;
        filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.5));
    }
    
    .video-card:hover:not(.locked-video) .play-button {
        opacity: 1;
        transform: scale(1.1);
    }
    
    .text-gold {
        color: gold !important;
    }
    
    .badge {
        font-weight: 600;
    }
    
    .border-bottom {
        border-color: #b8860b !important;
    }
    
    .locked-video {
        opacity: 0.7;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const courseProgress = document.getElementById("courseProgress");
    const progressPercentage = document.getElementById("progressPercentage");
    const progressText = document.getElementById("progressText");

    // Chave para armazenar no localStorage
    const STORAGE_KEY = 'video_progress';
    const allVideos = @json($videoIds);

    // Carregar progresso salvo
    function loadProgress() {
        const progress = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
        return progress;
    }

    // Verificar se um vídeo está concluído
    function isVideoCompleted(videoId) {
        const progress = loadProgress();
        return progress[videoId]?.completed || false;
    }

    // Verificar se um vídeo pode ser acessado (todos os anteriores concluídos)
    function canAccessVideo(videoId) {
        const videoIndex = allVideos.indexOf(parseInt(videoId));
        
        // Se for o primeiro vídeo, sempre pode acessar
        if (videoIndex === 0) return true;
        
        // Verificar se todos os vídeos anteriores foram concluídos
        for (let i = 0; i < videoIndex; i++) {
            if (!isVideoCompleted(allVideos[i])) {
                return false;
            }
        }
        return true;
    }

    // Atualizar barra de progresso do curso
    function updateCourseProgress() {
        const progress = loadProgress();
        const completedVideos = allVideos.filter(id => progress[id]?.completed).length;
        const progressPercentageValue = (completedVideos / allVideos.length) * 100;
        
        courseProgress.style.width = `${progressPercentageValue}%`;
        courseProgress.setAttribute('aria-valuenow', progressPercentageValue);
        progressPercentage.textContent = `${Math.round(progressPercentageValue)}%`;
        
        // Atualizar texto de progresso
        if (completedVideos === allVideos.length) {
            progressText.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i>Curso concluído! Parabéns!';
        } else if (completedVideos > 0) {
            progressText.textContent = `${completedVideos} de ${allVideos.length} vídeos concluídos`;
        } else {
            progressText.textContent = 'Complete os vídeos em ordem sequencial para desbloquear o conteúdo';
        }
    }

    // Atualizar acesso aos vídeos
    function updateVideoAccess() {
        const videoItems = document.querySelectorAll('.video-item');
        videoItems.forEach(item => {
            const videoId = item.getAttribute('data-video-id');
            const canAccess = canAccessVideo(videoId);
            const isLocked = item.getAttribute('data-locked') === 'true';
            
            // Se o acesso mudou, atualizar a UI
            if (canAccess && isLocked) {
                unlockVideo(item, videoId);
            }
        });
    }

    // Destravar vídeo
    function unlockVideo(videoItem, videoId) {
        const videoCard = videoItem.querySelector('.video-card');
        const videoLink = `{{ route('videos.show', '') }}/${videoId}`;
        
        // Remover overlay de bloqueio
        const lockedOverlay = videoCard.querySelector('.locked-overlay');
        if (lockedOverlay) lockedOverlay.remove();
        
        // Atualizar card para destravado
        videoCard.classList.remove('locked-video');
        videoCard.style.cursor = 'pointer';
        videoCard.querySelector('.card-img-top').classList.remove('opacity-50');
        videoCard.querySelector('.card-title').classList.remove('text-muted');
        
        // Atualizar badge de bloqueado para liberado
        const lockBadge = videoCard.querySelector('.bg-secondary');
        if (lockBadge) {
            lockBadge.className = 'badge bg-success bg-opacity-75 fs-7';
            lockBadge.innerHTML = '<i class="bi bi-unlock me-1"></i>Liberado';
        }
        
        // Remover botão bloqueado e adicionar link
        const cardBody = videoCard.querySelector('.card-body');
        const lockedButton = cardBody.querySelector('button');
        const lockedMessage = cardBody.querySelector('.text-warning');
        
        if (lockedButton) lockedButton.remove();
        if (lockedMessage) lockedMessage.remove();
        
        const watchLink = document.createElement('a');
        watchLink.href = videoLink;
        watchLink.className = 'btn w-100 fw-bold text-white';
        watchLink.style = 'background-color: #b8860b; border-radius: 10px;';
        watchLink.innerHTML = '<i class="bi bi-play-fill me-2"></i>Assistir';
        
        cardBody.querySelector('.mt-auto').appendChild(watchLink);
        
        // Envolver o card em um link
        const linkWrapper = document.createElement('a');
        linkWrapper.href = videoLink;
        linkWrapper.className = 'text-decoration-none';
        linkWrapper.innerHTML = videoCard.outerHTML;
        
        videoItem.innerHTML = '';
        videoItem.appendChild(linkWrapper);
        videoItem.setAttribute('data-locked', 'false');
    }

    // Verificar se houve mudanças no localStorage (de outras páginas)
    function checkForProgressUpdates() {
        const currentProgress = JSON.stringify(loadProgress());
        
        setInterval(() => {
            const newProgress = JSON.stringify(loadProgress());
            if (newProgress !== currentProgress) {
                updateCourseProgress();
                updateVideoAccess();
            }
        }, 1000);
    }

    // Inicializar
    updateCourseProgress();
    updateVideoAccess();
    checkForProgressUpdates();

    // Atualizar loading das imagens
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        img.style.transition = 'opacity 0.3s ease';
        img.style.opacity = '0.7';
    });
});
</script>
@endsection