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

                    <!-- Player com capa -->
                    <div class="position-relative text-center mb-4" style="border-radius: 15px; overflow: hidden;">
                        @if($video->caminho_thumbnail)
                            <img id="thumbnail" 
                                 src="{{ asset('storage/' . $video->caminho_thumbnail) }}" 
                                 alt="Thumbnail do Vídeo" 
                                 class="img-fluid rounded-3 shadow-sm w-100"
                                 style="max-height: 500px; object-fit: cover; cursor: pointer;">
                            <!-- Ícone de play -->
                            <div id="play-icon" 
                                 class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-50 p-4 rounded-circle"
                                 style="cursor: pointer;">
                                <i class="bi bi-play-fill text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <video id="videoPlayer" 
                               controls preload="metadata" 
                               class="w-100 rounded-3 shadow-sm" 
                               style="max-height: 500px; display: none;">
                            <source src="{{ asset('storage/' . $video->caminho_video) }}" type="video/mp4">
                            O seu navegador não suporta vídeo. 
                            <a href="{{ asset('storage/' . $video->caminho_video) }}">Baixe o arquivo aqui.</a>
                        </video>
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
                        </small>
                    </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Script para alternar imagem e vídeo -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const thumbnail = document.getElementById("thumbnail");
    const playIcon = document.getElementById("play-icon");
    const video = document.getElementById("videoPlayer");

    function startVideo() {
        thumbnail.style.display = "none";
        playIcon.style.display = "none";
        video.style.display = "block";
        video.play();
    }

    if (thumbnail && playIcon) {
        thumbnail.addEventListener("click", startVideo);
        playIcon.addEventListener("click", startVideo);
    }
});
</script>
@endsection
