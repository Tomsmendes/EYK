@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Editar Função</h1>
        <hr>
        <form action="{{  route('funcoes.update', ['id'=>$funcoes->id]) }}" method="POST"> 
        @csrf
        @method('PUT')
            <div class="form-group">
                <div class="form-group">
                    <label for="name_fc">Função</label>
                    <input type="text" name="name_fc" value="{{ $funcoes->name_fc }}" class="form-control" placeholder="Digite uma função...">
                </div>
                <br>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" value="{{ $funcoes->descricao }}" class="form-control" placeholder="Digite a descrição...">
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success" value="Atualizar">
                </div>
            </div>
        </form>
    </div>
@endsection
