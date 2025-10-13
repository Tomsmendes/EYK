@extends('layouts.nav')

@section('title', 'Casa')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Inicio</h1>

    {{-- Seção de Cursos --}}
<h2>Cursos em Destaque</h2>
<div class="row">
    @forelse($cursos as $curso)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                {{-- Thumbnail do curso --}}
                @if($curso->thumbnail)
                    <img src="{{ asset('uploads/cursos/' . $curso->thumbnail) }}"
                         alt="Thumbnail do curso {{ $curso->category }}" 
                         class="card-img-top" style="height: 180px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $curso->category }}</h5>

                    <p class="card-text">{{ Str::limit($curso->descricao, 100) }}</p>

                    {{-- Usuário dono do curso --}}
                    <small class="text-muted">
                        {{ $curso->user_name }}
                    </small><br>
                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-primary">Ver Curso</a>
                </div>
            </div>
        </div>
    @empty
        <p>Nenhum curso disponível.</p>
    @endforelse
</div>


    <hr class="my-5">
    {{-- Seção de Usuários em Destaque --}}
    <h2>Usuários em Destaque</h2>
    <div class="row">
    @forelse($usuarios as $user)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    {{-- Foto do usuário --}}
                    <img src="{{ $user->photo 
                                ? asset('uploads/' . $user->photo) 
                                : asset('media/avatar-default.png') }}" 
                         class="rounded-circle mb-3" width="100" height="100">

                    {{-- Nome do usuário (ajusta se o campo for "name" em vez de "vc_nome") --}}
                    <h5 class="card-title">{{ $user->vc_nome ??  'Usuário desconhecido' }}</h5>

                    {{-- Bio (se existir) --}}
                    <p class="card-text">{{ $user->bio ?? 'Usuário da plataforma EYK.' }}</p>

                    {{-- Link para perfil --}}
                    <a href="{{ route('perfil.show', $user->id) }}" class="btn btn-outline-secondary">Ver Perfil</a>
                </div>
            </div>
        </div>
    @empty
        <p>Nenhum usuário em destaque.</p>
    @endforelse
</div>

</div>
@endsection
