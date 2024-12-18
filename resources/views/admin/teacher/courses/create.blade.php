@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Novo Curso</h1>
    <form action="{{ route('teacher.courses.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nome do Curso:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div>
            <label for="description">Descrição:</label>
            <textarea name="description" id="description" required></textarea>
        </div>

        <button type="submit">Criar Curso</button>
    </form>
</div>
@endsection