@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
  
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-9">
                <h1>Listagem de Funçóes</h1>
            </div>
            <div class="col-sm-3">
                <a href="{{  route('funcoes.create') }}" class="btn btn-success">Nova função</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Função</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($funcoes as $funcao)
                <tr>
                    <th>{{ $funcao->id }}</th>
                    <th>{{ $funcao->name_fc }}</th>
                    <th>{{ $funcao->descricao }}</th>
                    <th class="d-flex">
                        <a href="{{  route('funcoes.edit', ['id'=>$funcao->id]) }}" class="btn btn-primary me-2" >Editar</a>
                        <form action="{{  route('funcoes.delete', ['id'=>$funcao->id]) }}" method="POST">
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