@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Novo Vídeo</h1>
    <form action="{{ route('teacher.videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div>
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" required></textarea>
        </div>

        <div>
            <label for="url">URL do Vídeo (opcional):</label>
            <input type="url" name="url" id="url">
        </div>

        <div>
            <label for="video_file">Ou envie um vídeo localmente:</label>
            <input type="file" name="video_file" id="video_file" accept="video/*">
        </div>

        <button type="submit">Criar Vídeo</button>
    </form>
</div>
@endsection
