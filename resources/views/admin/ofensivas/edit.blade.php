@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Editar Ofensiva</h1>
        <hr>
        <form action="{{ route('ofensivas.update', $ofensiva->id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" value="{{ $ofensiva->titulo }}" required>
        
            <label for="data">Data:</label>
            <input type="date" name="data" value="{{ $ofensiva->data }}" required>
        
            <label for="descricao">Descrição:</label>
            <textarea name="descricao">{{ $ofensiva->descricao }}</textarea>
        
            <button type="submit">Atualizar</button>
        </form>
        
    </div>
@endsection