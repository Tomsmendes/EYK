@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Criar Novo Video</h1>
        <hr>
        <form action="{{ route('videos.store') }}" method="POST"> 
        @csrf
            <div class="form-group">
                <label for="vd_name">Nome</label>
                <input type="text" name="vd_name" class="form-control" placeholder="Digite um nome...">
            </div>
            <br>
            <div class="form-group">
                <label for="url">Url</label>
                <input type="url" name="url" class="form-control" placeholder="Digite a Url...">
            </div>
            <br>
            <div class="form-group">
                <label for="vd_descricao">Descrição</label>
                <input type="text" name="vd_descricao" class="form-control" placeholder="Digite uma Descrição...">
            </div>
            <br>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
@endsection
