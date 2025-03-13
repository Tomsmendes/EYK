@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
  
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-9">
                <h1>Listagem de Faqs</h1>
            </div>
            <div class="col-sm-3">
                <a href="{{  route('faqs.create') }}" class="btn btn-success">Novo Faqs</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Questão</th>
                    <th scope="col">Resposta</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Ordem</th>
                    <th scope="col">opcão</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($faqs as $faq)
                <tr>
                    <th>{{ $faq->id }}</th>
                    <th>{{ $faq->question }}</th>
                    <th>{{ $faq->answer }}</th>
                    <th>{{ $faq->category_f }}</th>
                    <th>{{ $faq->order }}</th>
                    <th class="d-flex">
                        <a href="{{  route('faqs.edit', ['id'=>$faq->id]) }}" class="btn btn-primary me-2" >Editar</a>
                        <form action="{{  route('faqs.delete', ['id'=>$faq->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Eliminar</button>
                        </form>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection