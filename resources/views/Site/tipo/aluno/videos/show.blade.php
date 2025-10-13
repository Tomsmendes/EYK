@extends('Site.tipo.layouts.home')

@section('title', 'Detalhes do Vídeo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Cabeçalho -->
                <div class="card-header text-white text-center py-4 rounded-top-4"
                     style="background: linear-gradient(90deg, #b8860b, #ffd700);">
                    <h2 class="fw-bold mb-0">{{ $video->titulo }}</h2>
                </div>

                <!-- Corpo -->
                <div class="card-body bg-light p-4">

                    <!-- Barra de Progresso do Curso -->
                    <div class="progress mb-4" style="height: 8px; border-radius: 10px;">
                        <div id="courseProgress" class="progress-bar" 
                             style="background: linear-gradient(90deg, #b8860b, #ffd700);"
                             role="progressbar" 
                             aria-valuenow="0" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                        </div>
                    </div>

                    <!-- Player com capa -->
                    <div class="position-relative text-center mb-4" style="border-radius: 15px; overflow: hidden;">
                        @if($video->caminho_thumbnail)
                            <img id="thumbnail" 
                                 src="{{ asset('storage/' . $video->caminho_thumbnail) }}" 
                                 alt="Thumbnail do Vídeo" 
                                 class="img-fluid rounded-3 shadow-sm w-100"
                                 style="max-height: 500px; object-fit: cover; cursor: pointer; display: block;">
                            <!-- Ícone de play -->
                            <div id="play-icon" 
                                 class="position-absolute top-50 start-50 translate-middle"
                                 style="cursor: pointer; display: block;">
                                <i class="bi bi-play-circle-fill text-white" style="font-size: 4rem; text-shadow: 0 2px 10px rgba(0,0,0,0.5);"></i>
                            </div>
                        @endif

                        <video id="videoPlayer" 
                               controls 
                               class="w-100 rounded-3 shadow-sm" 
                               style="max-height: 500px; display: none;"
                               poster="{{ $video->caminho_thumbnail ? asset('storage/' . $video->caminho_thumbnail) : '' }}"
                               data-video-id="{{ $video->id }}">
                            <source src="{{ asset('storage/' . $video->caminho_video) }}" type="video/mp4">
                            Seu navegador não suporta o elemento de vídeo.
                        </video>
                    </div>

                    <!-- Status do Vídeo -->
                    <div id="videoStatus" class="alert alert-info d-none">
                        <i class="bi bi-info-circle me-2"></i>
                        <span id="statusText"></span>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-4">
                        <h5 class="fw-semibold text-dark">📜 Descrição:</h5>
                        <p class="text-muted fs-5">{{ $video->descricao ?? 'Sem descrição disponível.' }}</p>
                    </div>

                    <!-- Informações adicionais -->
                    <div class="bg-white p-3 rounded-3 shadow-sm mb-4">
                        <small class="text-secondary">
                            <strong>Data de Upload:</strong> {{ $video->created_at->format('d/m/Y H:i') }} <br>
                            @if($video->aula)
                                <strong>Aula:</strong> {{ $video->aula->title }} <br>
                            @endif
                            <strong>Status:</strong> <span id="completionStatus">Não iniciado</span>
                        </small>
                    </div>

                </div>
            </div>

            <!-- Lista de Próximos Vídeos -->
            <div class="card shadow-lg border-0 rounded-4 mt-4">
                <div class="card-header text-white py-3 rounded-top-4"
                     style="background: linear-gradient(90deg, #b8860b, #ffd700);">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-play-circle me-2"></i>Próximos Vídeos
                    </h4>
                </div>
                <div class="card-body">
                    @php
                        // Buscar todos os vídeos ordenados por data de criação
                        $allVideos = App\Models\Video::with('aula')->orderBy('created_at', 'asc')->get();
                        $currentVideoIndex = $allVideos->search(function($item) use ($video) {
                            return $item->id === $video->id;
                        });
                        $nextVideos = $allVideos->slice($currentVideoIndex + 1);
                        
                        // Carregar progresso do localStorage via JavaScript
                        $videoIds = $allVideos->pluck('id')->toArray();
                    @endphp

                    @if($nextVideos->count() > 0)
                        <div class="row g-3">
                            @foreach($nextVideos as $nextVideo)
                                @php
                                    // Este cálculo será feito via JavaScript
                                    $videoOrder = $loop->iteration + $currentVideoIndex + 1;
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div class="video-item" 
                                         data-video-id="{{ $nextVideo->id }}" 
                                         data-video-order="{{ $videoOrder }}"
                                         data-locked="true">
                                        <div class="card border-0 shadow-sm h-100 video-card locked-video" 
                                             style="cursor: not-allowed; position: relative;">
                                            <div class="locked-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center rounded-3"
                                                 style="background: rgba(0,0,0,0.7); z-index: 10;">
                                                <i class="bi bi-lock-fill text-warning fs-1"></i>
                                            </div>
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $nextVideo->caminho_thumbnail) }}" 
                                                     alt="{{ $nextVideo->titulo }}"
                                                     class="card-img-top opacity-50"
                                                     style="height: 160px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 m-2">
                                                    <span class="badge bg-dark bg-opacity-75 fs-7">
                                                        <i class="bi bi-play-circle me-1"></i>
                                                        {{ $videoOrder }}
                                                    </span>
                                                </div>
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <i class="bi bi-play-circle-fill fs-2 text-white opacity-0 play-button-small"></i>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-title fw-semibold mb-2 text-truncate text-muted">
                                                    {{ $nextVideo->titulo }}
                                                </h6>
                                                @if($nextVideo->aula)
                                                    <small class="text-muted d-block">
                                                        <i class="bi bi-collection-play me-1"></i>
                                                        {{ $nextVideo->aula->title }}
                                                    </small>
                                                @endif
                                                <small class="text-muted">
                                                    {{ $nextVideo->created_at->format('d/m/Y') }}
                                                </small>
                                                <div class="mt-2">
                                                    <small class="text-warning">
                                                        <i class="bi bi-lock me-1"></i>Complete os vídeos anteriores
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-flag-fill fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Parabéns! 🎉</h5>
                            <p class="text-muted">Você completou todos os vídeos disponíveis.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Adicionar Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
.video-card {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.video-card:hover:not(.locked-video) {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(184, 134, 11, 0.3);
}

.video-card:hover:not(.locked-video) .play-button-small {
    opacity: 1 !important;
    transform: scale(1.1);
}

.play-button-small {
    transition: all 0.3s ease;
    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.5));
}

#play-icon {
    transition: all 0.3s ease;
}

#play-icon:hover {
    transform: scale(1.1);
}

.locked-video {
    opacity: 0.7;
}

.progress-bar {
    transition: width 0.5s ease;
}

.unlocked-video {
    opacity: 1;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const thumbnail = document.getElementById("thumbnail");
    const playIcon = document.getElementById("play-icon");
    const video = document.getElementById("videoPlayer");
    const videoStatus = document.getElementById("videoStatus");
    const statusText = document.getElementById("statusText");
    const completionStatus = document.getElementById("completionStatus");
    const courseProgress = document.getElementById("courseProgress");

    // Chave para armazenar no localStorage
    const STORAGE_KEY = 'video_progress';
    const currentVideoId = {{ $video->id }};
    const allVideos = @json($videoIds);
    const currentVideoIndex = allVideos.indexOf(currentVideoId);

    // Carregar progresso salvo
    function loadProgress() {
        const progress = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
        return progress;
    }

    // Salvar progresso
    function saveProgress(videoId, completed = false, progress = 0) {
        const progressData = loadProgress();
        progressData[videoId] = {
            completed: completed,
            progress: progress,
            timestamp: new Date().toISOString()
        };
        localStorage.setItem(STORAGE_KEY, JSON.stringify(progressData));
        updateUI();
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

    // Atualizar interface com base no progresso
    function updateUI() {
        const progress = loadProgress();
        const currentProgress = progress[currentVideoId];
        
        if (currentProgress) {
            if (currentProgress.completed) {
                completionStatus.textContent = 'Concluído ✓';
                completionStatus.className = 'text-success';
            } else {
                completionStatus.textContent = 'Em andamento';
                completionStatus.className = 'text-warning';
            }
        } else {
            completionStatus.textContent = 'Não iniciado';
            completionStatus.className = 'text-secondary';
        }

        // Atualizar progresso geral do curso
        updateCourseProgress();
        
        // Atualizar estado dos vídeos bloqueados/destravados
        updateVideoAccess();
    }

    // Atualizar barra de progresso do curso
    function updateCourseProgress() {
        const progress = loadProgress();
        const completedVideos = allVideos.filter(id => progress[id]?.completed).length;
        const progressPercentage = (completedVideos / allVideos.length) * 100;
        
        courseProgress.style.width = `${progressPercentage}%`;
        courseProgress.setAttribute('aria-valuenow', progressPercentage);
        courseProgress.innerHTML = `${Math.round(progressPercentage)}%`;
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
        videoCard.classList.add('unlocked-video');
        videoCard.style.cursor = 'pointer';
        videoCard.querySelector('.card-img-top').classList.remove('opacity-50');
        videoCard.querySelector('.card-title').classList.remove('text-muted');
        videoCard.querySelector('.card-title').classList.add('text-dark');
        
        // Remover mensagem de bloqueio
        const lockMessage = videoCard.querySelector('.text-warning');
        if (lockMessage) lockMessage.remove();
        
        // Adicionar link
        const link = document.createElement('a');
        link.href = videoLink;
        link.className = 'text-decoration-none';
        
        // Clonar o card sem o overlay
        const cardClone = videoCard.cloneNode(true);
        link.appendChild(cardClone);
        
        videoItem.innerHTML = '';
        videoItem.appendChild(link);
        videoItem.setAttribute('data-locked', 'false');
        
        // Adicionar eventos hover no novo card
        const newCard = videoItem.querySelector('.video-card');
        newCard.addEventListener('mouseenter', function() {
            if (!this.classList.contains('locked-video')) {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 25px rgba(184, 134, 11, 0.3)';
                const playBtn = this.querySelector('.play-button-small');
                if (playBtn) {
                    playBtn.style.opacity = '1';
                    playBtn.style.transform = 'scale(1.1)';
                }
            }
        });

        newCard.addEventListener('mouseleave', function() {
            if (!this.classList.contains('locked-video')) {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                const playBtn = this.querySelector('.play-button-small');
                if (playBtn) {
                    playBtn.style.opacity = '0';
                    playBtn.style.transform = 'scale(1)';
                }
            }
        });
    }

    // Função para iniciar o vídeo
    function startVideo() {
        console.log('Iniciando vídeo...');
        
        if (thumbnail) thumbnail.style.display = "none";
        if (playIcon) playIcon.style.display = "none";
        
        if (video) {
            video.style.display = "block";
            
            // Tenta reproduzir o vídeo
            video.play().then(() => {
                console.log('Vídeo iniciado com sucesso');
                showStatus('Vídeo em reprodução...', 'info');
                
                // Marcar como iniciado se não estiver concluído
                if (!isVideoCompleted(currentVideoId)) {
                    saveProgress(currentVideoId, false, 0);
                }
            }).catch(error => {
                console.error('Erro ao reproduzir vídeo:', error);
                video.style.display = "block";
                if (thumbnail) thumbnail.style.display = "none";
                if (playIcon) playIcon.style.display = "none";
            });
        }
    }

    // Mostrar status
    function showStatus(message, type = 'info') {
        statusText.textContent = message;
        videoStatus.className = `alert alert-${type}`;
        videoStatus.classList.remove('d-none');
        
        setTimeout(() => {
            videoStatus.classList.add('d-none');
        }, 5000);
    }

    // Adiciona event listeners
    if (thumbnail) thumbnail.addEventListener("click", startVideo);
    if (playIcon) playIcon.addEventListener("click", startVideo);

    // Monitorar progresso do vídeo
    if (video) {
        // Salvar progresso a cada 10 segundos
        video.addEventListener('timeupdate', function() {
            const progress = (video.currentTime / video.duration) * 100;
            if (progress > 5) { // Só salva se assistiu pelo menos 5%
                saveProgress(currentVideoId, false, progress);
            }
        });

        // Quando o vídeo terminar
        video.addEventListener('ended', function() {
            console.log('Vídeo concluído!');
            saveProgress(currentVideoId, true, 100);
            showStatus('Vídeo concluído com sucesso! Verificando próximos vídeos...', 'success');
            
            // Atualizar acesso aos próximos vídeos
            setTimeout(() => {
                updateVideoAccess();
                showStatus('Próximos vídeos verificados!', 'success');
            }, 2000);
        });

        // Log para debug
        video.addEventListener('loadstart', () => console.log('Vídeo começando a carregar'));
        video.addEventListener('canplay', () => console.log('Vídeo pode ser reproduzido'));
        video.addEventListener('error', (e) => console.error('Erro no vídeo:', e));
    }

    // Teclas de atalho
    document.addEventListener('keydown', function(e) {
        // Espaço para play/pause (apenas quando o vídeo está visível)
        if (e.code === 'Space' && video.style.display === 'block') {
            e.preventDefault();
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        }
        
        // Tecla 'N' para próximo vídeo (apenas se destravado)
        if (e.code === 'KeyN') {
            const firstUnlockedVideo = document.querySelector('.video-item[data-locked="false"] .video-card');
            if (firstUnlockedVideo) {
                const videoLink = firstUnlockedVideo.closest('a');
                if (videoLink) {
                    window.location.href = videoLink.href;
                }
            }
        }
    });

    // Inicializar UI
    updateUI();
});
</script>
@endsection