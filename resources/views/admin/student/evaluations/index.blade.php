@extends('layouts.dash')

@section('content')
    <h1>Minhas Avaliações</h1>
    <ul>
        @foreach($evaluations as $evaluation)
            <li>
                Curso: {{ $evaluation->course->name }}<br>
                Avaliação: {{ $evaluation->rating }} estrelas<br>
                Feedback: {{ $evaluation->feedback }}
            </li>
        @endforeach
    </ul>
@endsection