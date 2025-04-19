@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
  
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-9">
                <h1>Listagem de Ofensivas</h1>
            </div>
            <div class="col-sm-3">
                <a href="{{  route('ofensivas.create') }}" class="btn btn-success">Nova Ofensiva</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Título</th>
                    <th>Data</th>
                    <th scope="col">opcão</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($ofensivas as $ofensiva)
                <tr>
                    <th>{{ $ofensiva->id }}</th>
                    <th>{{ $ofensiva->titulo }}</th>
                    <th>{{ $ofensiva->data }}</th>
                    <th class="d-flex">
                        <a href="{{  route('ofensivas.edit', ['id'=>$ofensiva->id]) }}" class="btn btn-primary me-2" >Editar</a>
                        <form action="{{  route('ofensivas.delete', ['id'=>$ofensiva->id]) }}" method="POST">
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