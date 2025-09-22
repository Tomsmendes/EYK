@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Upload de Vídeo</h2>

    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Título --}}
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                   name="titulo" value="{{ old('titulo') }}" required>
            @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descrição --}}
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control @error('descricao') is-invalid @enderror"
                      name="descricao" rows="4">{{ old('descricao') }}</textarea>
            @error('descricao')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Vídeo --}}
        <div class="mb-3">
            <label for="video" class="form-label">Selecione o vídeo</label>
            <input type="file" class="form-control @error('video') is-invalid @enderror"
                   name="video" accept="video/mp4,video/webm" required>
            @error('video')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Thumbnail --}}
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail (opcional)</label>
            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                   name="thumbnail" accept="image/*">
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Aula relacionada --}}
        <div class="mb-4">
            <label for="aula_id" class="form-label">Curso relacionado (opcional)</label>
            <select class="form-select" name="aula_id" id="aula_id">
                <option value="">Nenhum Curso</option>
                @foreach ($aulas as $aula)
                    <option value="{{ $aula->id }}" {{ old('aula_id') == $aula->id ? 'selected' : '' }}>
                        {{ $aula->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-upload"></i> Enviar Vídeo
        </button>
    </form>
</div>
@endsection
