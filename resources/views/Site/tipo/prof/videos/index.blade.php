@extends('Site.tipo.layouts.home')

@section('title', 'Detalhes do Curso')

@section('content')
<div class="container">
    <h2>Meus Vídeos</h2>
    <a href="{{ route('videos.create') }}" class="btn btn-primary mb-3">Novo Upload</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="row">
        @forelse($videos as $video)
        <div class="col-md-4 mb-3">
            <div class="card">
                @if($video->caminho_thumbnail)
                    <img src="{{ asset('storage/' . $video->caminho_thumbnail) }}" class="card-img-top" alt="Thumb">
                @endif
                <div class="card-body">
                    <h5>{{ $video->titulo }}</h5>
                    <p>{{ Str::limit($video->descricao, 100) }}</p>
                    <small>Status: {{ ucfirst($video->upload_status) }}</small>
                    <a href="{{ route('videos.show', $video) }}" class="btn btn-success mt-2">Ver ▶</a>
                </div>
            </div>
        </div>
        @empty
        <p>Nenhum vídeo. <a href="{{ route('videos.create') }}">Comece um!</a></p>
        @endforelse
    </div>
</div>
@endsection