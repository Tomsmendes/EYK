@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Editar Videos</h1>
        <hr>
        <form action="{{ route('videos.update', ['id' => $videos->id]) }}" method="POST">
        @csrf
        @method('PUT')
            <div class="form-group">
                <div class="form-group">
                    <label for="vd_name">Nome</label>
                    <input type="text" name="vd_name" value="{{ $videos->vd_name }}" class="form-control" placeholder="Digite um nome...">
                </div>
                <br>
                <div class="form-group">
                    <label for="url">Url</label>
                    <input type="url" name="url" value="{{ $videos->url }}" class="form-control" placeholder="Digite a Url...">
                </div>
                <br>
                <div class="form-group">
                    <label for="vd_descricao">Descrição</label>
                    <input type="text" name="vd_descricao" value="{{ $videos->vd_descricao }}"  class="form-control" placeholder="Digite uma Descrição...">
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success" value="Atualizar">
                </div>
            </div>
        </form>
    </div>
@endsection
