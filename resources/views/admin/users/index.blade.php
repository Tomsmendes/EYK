@extends('layouts.app')

@section('title', 'Listagem')

@section('content')
  
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-9">
                <h1>Listagem de Usuarios</h1>
            </div>
            <div class="col-sm-3">
                <a href="{{  route('users.create') }}" class="btn btn-success">Novo usuario</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Função</th>
                    <th scope="col">Fotos</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <th>{{ $user->id}}</th>
                    <th>{{ $user->name}}</th>
                    <th>{{ $user->email}}</th>
                    <th>{{ $user->f_nome}}</th>
                    <th>
                        <div class="showPhoto"> 
                            @if($user->photo)
                                <img src="{{ url('/uploads/'.$user->photo) }}" alt="Foto de {{ $user->name }}" class="img-thumbnail">
                            @else
                                <img src="{{ url('/uploads/default.png') }}" alt="Imagem padrão" class="img-thumbnail">
                            @endif
                        </div>
                    </th>
                    
                    <th >
                        <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{  route('users.delete', ['id'=>$user->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')"> Eliminar </button>
                        </form>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
       
    </div>
@endsection
<style>
    .showPhoto img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>