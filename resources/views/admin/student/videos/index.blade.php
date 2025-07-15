@extends('layouts.app')

@section('content')
    <h1>Vídeos Disponíveis</h1>
    <ul>
        @foreach($videos as $video)
            <li>
                <strong>{{ $video->title }}</strong>
                <p>{{ $video->description }}</p>
                <a href="{{ $video->url }}" target="_blank">Assistir</a>
            </li>
        @endforeach
    </ul>
@endsection