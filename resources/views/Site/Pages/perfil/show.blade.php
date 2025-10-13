@extends('layouts.nav')

@section('title', 'Perfil de ' . $user->vc_nome)

@section('content')

<div class="container mt-4">
    <div class="row">
        {{-- Lado esquerdo: info do usuário --}}
        <div class="col-md-4 text-center">
            <img src="{{ $user->photo 
                                ? asset('uploads/' . $user->photo) 
                                : asset('media/avatar-default.png') }}" 
                 class="rounded-circle mb-3" width="150" height="150" alt="$user->vc_nome">

            <h2>{{ $user->vc_nome ?? 'Carregar nome...'}}</h2>
            <p>{{ $user->bio ?? 'Este usuário ainda não adicionou uma bio.' }}</p>
        </div>

        {{-- Lado direito: cursos --}}
        <div class="col-md-8">
            <h3>Cursos de {{ $user->vc_nome }}</h3>
            
            @if($cursos->isEmpty())
                <p>Este usuário ainda não publicou nenhum curso.</p>
            @else
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
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
