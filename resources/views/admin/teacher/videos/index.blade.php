@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Meus Vídeos</h1>
    <ul>
        @foreach($videos as $video)
            <li>
                <a href="{{ $video->url }}" target="_blank">{{ $video->title }}</a>
                <p>{{ $video->description }}</p>
            </li>
        @endforeach
    </ul>
</div>
@endsection