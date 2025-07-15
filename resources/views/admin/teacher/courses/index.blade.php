@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Meus Cursos</h1>
    <ul>
        @foreach($courses as $course)
            <li>
                <h2>{{ $course->name }}</h2>
                <p>{{ $course->description }}</p>
            </li>
        @endforeach
    </ul>
</div>
@endsection