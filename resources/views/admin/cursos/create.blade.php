@extends('layouts.app')

@section('content')
<h2>Criar Novo Curso</h2>
<form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Categoria:</label>
    <input type="text" name="category" required>
    
    <label>Status:</label>
    <select name="status">
        <option value="draft">Rascunho</option>
        <option value="published">Publicado</option>
    </select>

    <label>Preço:</label>
    <input type="number" name="price" step="0.01">

    <label>Duração:</label>
    <input type="text" name="duration">

    <label>Imagem:</label>
    <input type="file" name="thumbnail">

    <button type="submit">Salvar</button>
</form>
@endsection
