@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
  
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-9">
                <h1>Listagem de Cursos</h1>
            </div>
            <div class="col-sm-3">
                <a href="{{ route('cursos.create') }}" class="btn btn-success">Novo Curso</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Categoria</th>
                    <th>Status</th>
                    <th>Preço</th>
                    <th>Duração</th>
                    <th>Imagem</th>
                    <th>opções</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($cursos as $curso)
                <tr>
                    <th>{{ $curso->id}}</th>
                    <th>{{ $curso->category }}</th>
                    <th>{{ ucfirst($curso->status) }}</th>
                    <th>{{ $curso->price ? 'Kz ' . number_format($curso->price, 2) : '-' }}</th>
                    <th>{{ $curso->duration }}</th>
                    <th>
                        <div class="showPhoto"> 
                            @if($curso->thumbnail)
                                <img src="{{ url('/uploads/'.$curso->thumbnail) }}" alt="Foto de {{ $curso->category }}" class="img-thumbnail">
                            @else
                                <img src="{{ url('/uploads/'.$curso->thumbnail) }}" alt="Imagem padrão" class="img-thumbnail">
                            @endif
                        </div>
                    </th>
                    
                    <th >
                        <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('cursos.delete', $curso->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
       
    </div>
@endsection
<style>
    .showPhoto img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>




