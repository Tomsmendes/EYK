@extends('Site.tipo.layouts.home')

@section('title', 'Listagem de Cursos')

@section('content')
<div class="container mt-5">
    <h1 class="text-center fw-bold mb-5" style="color: gold;">Todos os Cursos</h1>

    @if (session('success'))
        <div class="alert alert-success text-center fw-semibold" style="background-color: #fff8e1; color: #c79a00; border: 1px solid gold;">
            {{ session('success') }}
        </div>
    @endif

    <div id="cursosCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($cursos->chunk(4) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                    <div class="row g-4 justify-content-center">
                        @foreach ($chunk as $curso)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <a href="{{ route('cursos.show', $curso->id) }}" class="text-decoration-none">
                                    <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden position-relative" 
                                         style="background-color: #fffdf5; transition: all 0.3s ease; border: 2px solid transparent;">
                                        
                                        <img src="{{ asset('uploads/cursos/' . $curso->thumbnail) }}" 
                                             class="card-img-top" 
                                             alt="{{ $curso->description }}" 
                                             style="height: 180px; object-fit: cover; border-bottom: 3px solid gold;">
                                        
                                        <div class="card-body text-center p-4">
                                            <h5 class="card-title fw-bold mb-3" style="color: gold;">{{ $curso->name_curso }}</h5>
                                            <p class="card-text mb-2">
                                                <strong class="text-muted">Categoria:</strong>
                                                <span style="color: darkgoldenrod; font-weight: 600;">{{ $curso->category }}</span>
                                            </p>
                                            <p class="card-text mb-0">
                                                <strong class="text-muted">Usuário:</strong>
                                                <span style="color: #333;">{{ $curso->user_name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#cursosCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: gold; border-radius: 50%; padding: 10px;"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cursosCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: gold; border-radius: 50%; padding: 10px;"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-8px);
        border-color: gold;
        box-shadow: 0 6px 20px rgba(255, 215, 0, 0.3);
    }
    .btn:hover {
        background-color: darkgoldenrod !important;
        transform: scale(1.05);
    }
</style>
@endsection
