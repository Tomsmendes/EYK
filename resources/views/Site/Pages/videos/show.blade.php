@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $video->titulo }}</h1>
    <p>{{ $video->descricao }}</p>
    
    @if($video->caminho_thumbnail)
        <img src="{{ asset('storage/' . $video->caminho_thumbnail) }}" alt="Thumb" class="img-fluid mb-3">
    @endif

    <video controls preload="metadata" class="w-100" style="max-height: 500px;">
        <source src="{{ asset('storage/' . $video->caminho_video) }}" type="video/mp4">
        Não suporta? <a href="{{ asset('storage/' . $video->caminho_video) }}">Baixe grátis</a>.
    </video>
    
    <a href="{{ route('videos.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection