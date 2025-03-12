@extends('layouts.app')

@section('content')
<h2>Lista de Cursos</h2>
<a href="{{ route('cursos.create') }}" class="btn btn-primary">Criar Novo Curso</a>

<table class="table">
    <thead>
        <tr>
            <th>Categoria</th>
            <th>Status</th>
            <th>Preço</th>
            <th>Duração</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cursos as $curso)
        <tr>
            <td>{{ $curso->category }}</td>
            <td>{{ ucfirst($curso->status) }}</td>
            <td>{{ $curso->price ? 'Kz ' . number_format($curso->price, 2) : '-' }}</td>
            <td>{{ $curso->duration }}</td>
            <td>
                @if($curso->thumbnail)
                    <img src="{{ asset($curso->thumbnail) }}" width="50">
                @endif
            </td>
            <td>
                <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-info">Ver</a>
                <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
