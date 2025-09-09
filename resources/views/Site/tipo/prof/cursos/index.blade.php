@extends('Site.tipo.layouts.home')

@section('title', 'Listagem de Cursos')

@section('content')
<div class="container mt-5">
    <h1 class="text-center fw-bold mb-4">Todos os Cursos</h1>
    <a href="{{ route('cursos.create') }}" class="btn btn-primary mb-4">Novo Curso</a>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div id="cursosCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($cursos->chunk(4) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                    <div class="row g-4 justify-content-center">
                        @foreach ($chunk as $curso)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <a href="{{ route('cursos.show', $curso->id) }}" class="text-decoration-none">
                                    <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden bg-white position-relative" style="transition: transform 0.3s; height: auto; border-radius: 15px;">
                                        <img src="{{ asset('uploads/cursos/' . $curso->thumbnail) }}" class="card-img-top p-3" alt="{{ $curso->description }}" style="height: 180px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                        <div class="card-body text-dark p-4">
                                            <h5 class="card-title mb-3 text-primary fw-bold">{{ $curso->description }}</h5>
                                            <p class="card-text mb-2"><strong class="text-muted">Categoria:</strong> <span class="text-success fw-medium">{{ $curso->category }}</span></p>
                                            <p class="card-text mb-2"><strong class="text-muted">Preço:</strong> <span class="text-danger fw-medium">{{ number_format($curso->price, 2, ',', '.') }} €</span></p>
                                            <p class="card-text mb-2"><strong class="text-muted">Duração:</strong> <span class="fw-medium">{{ $curso->duration }} min</span></p>
                                            <p class="card-text mb-0"><strong class="text-muted">Usuário:</strong> <span class="fw-medium">{{ $curso->user_name }}</span></p>
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
            <span class="carousel-control-prev-icon bg-dark bg-opacity-50 rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cursosCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark bg-opacity-50 rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
</div>
@endsection