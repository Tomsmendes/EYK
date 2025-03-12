@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
  
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-9">
                <h1>Listagem de Videos</h1>
            </div>
            <div class="col-sm-3">
                <a href="{{  route('videos.create') }}" class="btn btn-success">Novo Video</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Url</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($videos as $video)
                <tr>
                    <th>{{ $video->id}}</th>
                    <th>{{ $video->vd_name}}</th>
                    <th>{{ $video->url}}</th>
                    <th>{{ $video->vd_descricao}}</th>
                    <th class="d-flex">
                        <a href="{{  route('videos.edit', ['id'=>$video->id], ) }}" class="btn btn-primary me-2" >Editar</a>
                        <form action="{{  route('videos.delete', ['id'=>$video->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" >Eliminar</button>
                        </form>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection