@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Meus Vídeos</h1>

    @if($videos->isEmpty())
        <div class="alert alert-info">
            Nenhum vídeo encontrado.
        </div>
    @else
        <div class="row g-4">
            @foreach($videos as $video)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body" style="border:2px solid;border-radius:4px ">
                                <h5 class="card-title">{{ $video->titulo }}</h5>
                            <video class="w-100 rounded" controls >
                                <source src="{{ asset('storage/' . $video->caminho_video) }}" type="video/mp4">
                                    Seu navegador não suporta vídeo.
                                </video>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
