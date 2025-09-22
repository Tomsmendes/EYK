@extends('layouts.nav')

@section('title', 'Videos | EYK')

@section('content')

<div class="container mt-5">
    <h2>Vídeos</h2>

    <div class="row">
        @foreach($videos as $video)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="video-wrapper position-relative" >
                        @if($video->caminho_thumbnail)
                            {{-- Thumbnail com botão play --}}
                            <img src="{{ asset('storage/'.$video->caminho_thumbnail) }}"
                                 class="img-fluid video-thumb"
                                 data-video="{{ asset('storage/'.$video->caminho_video) }}"
                                 alt="Thumbnail do vídeo">
                            <div class="play-button position-absolute top-50 start-50 translate-middle">▶️</div>
                        @else
                            {{-- Se não tem thumbnail, já mostra o vídeo como "capa" --}}
                            <video class="img-fluid video-thumb"
                                   data-video="{{ asset('storage/'.$video->caminho_video) }}"
                                   muted loop>
                                <source src="{{ asset('storage/'.$video->caminho_video) }}" type="video/mp4">
                                Seu navegador não suporta vídeo.
                            </video>
                            <div class="play-button position-absolute top-50 start-50 translate-middle">▶️</div>
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $video->titulo }}</h5>
                        <p class="card-text">{{ $video->descricao }}</p>
                        <p class="text-muted" >Professor: {{ $video->user->vc_nome }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white" id="videoModalLabel">{{ $video->titulo }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body p-0">
        <video id="videoPlayer" class="w-100" controls></video>
      </div>
    </div>
  </div>
</div>

{{-- Script para abrir vídeo no modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = new bootstrap.Modal(document.getElementById('videoModal'));
    const videoPlayer = document.getElementById('videoPlayer');

    document.querySelectorAll('.video-thumb').forEach(thumb => {
        thumb.addEventListener('click', function () {
            const videoSrc = this.getAttribute('data-video');
            videoPlayer.src = videoSrc;
            videoPlayer.play();
            modal.show();
        });
    });

    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
        videoPlayer.src = "";
    });
});
</script>

<style>
.play-button {
    font-size: 3rem;
    color: white;
    text-shadow: 0 0 10px black;
    cursor: pointer;
    pointer-events: none;
}
.video-wrapper {
    cursor: pointer;
}
#videoPlayer{
    /* width:10%; */
}
</style>
@endsection
