@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-height: 80vh; overflow-y: auto;">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4 text-center">Criar Novo Vídeo</h1>
        <form action="{{ route('teacher.videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Título:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição:</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">URL do Vídeo (opcional):</label>
                <input type="url" name="url" id="url" class="form-control">
            </div>

            <div class="mb-3">
                <label for="video_file" class="form-label">Ou envie um vídeo localmente:</label>
                <input type="file" name="video_file" id="video_file" class="form-control" accept="video/*" onchange="previewVideo(event)">
            </div>

            <div class="mb-3 text-center" id="video-preview-container" style="display: none;">
                <video id="video-preview" controls class="rounded shadow" style="max-width: 50%; height: auto;"></video>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Criar Vídeo</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewVideo(event) {
        const file = event.target.files[0];
        if (file) {
            const videoPreview = document.getElementById('video-preview');
            const previewContainer = document.getElementById('video-preview-container');
            videoPreview.src = URL.createObjectURL(file);
            previewContainer.style.display = 'block';
        }
    }
</script>
@endsection
