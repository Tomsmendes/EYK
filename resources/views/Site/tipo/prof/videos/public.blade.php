@extends('Site.tipo.layouts.home')

@section('title', 'Detalhes do Curso')

@section('content')
<div class="container">
    <h2>Biblioteca Gratuita</h2>
    <div class="row">
        @forelse($videos as $video)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $video->titulo }} por {{ $video->user->name ?? 'Usuário' }}</h5>
                    <p>{{ Str::limit($video->descricao, 50) }}...</p>
                    <a href="{{ route('videos.show', $video) }}" class="btn btn-info">Assistir ▶</a>
                </div>
            </div>
        </div>
        @empty
        <p>Vazia por enquanto.</p>
        @endforelse
    </div>
    <a href="{{ route('home') }}" class="btn btn-secondary">Home</a>
</div>
@endsection