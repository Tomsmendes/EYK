<!-- resources/views/admin/user/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Olá! Prof. {{ Auth::user()->name }}!</h2>
    <h2>Lista de Usuários</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Papel</th>
                <th>Data de Criação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{ route('logout') }}" method="POST" class="mt-3" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-danger btn-lg">Sair</button>
    </form>
</div>
@endsection
