@extends('layouts.dash')

@section('content')
    <h1>FAQ</h1>
    <ul>
        @foreach($faqs as $faq)
            <li>
                <strong>{{ $faq->question }}</strong>
                <p>{{ $faq->answer }}</p>
            </li>
        @endforeach
    </ul>
@endsection