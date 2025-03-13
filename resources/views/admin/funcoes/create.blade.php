@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Criar Nova Função</h1>
        <hr>
        <form action="{{ route('funcoes.store') }}" method="POST"> 
        @csrf
            <div class="form-group">
                <div class="form-group">
                    <label for="name_fc">Funcão</label>
                    <input type="text" name="name_fc" class="form-control" placeholder="Digite uma função...">
                </div>
                <br>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" class="form-control" placeholder="Digite a descrição...">
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
@endsection
