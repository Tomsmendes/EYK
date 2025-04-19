@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Criar Nova Ofensiva</h1>
        <hr>
        <form action="{{ route('ofensivas.store') }}" method="POST"> 
        @csrf
            <div class="form-group">
                <div class="form-group">
                    <label for="titulo">Questão</label>
                    <input type="text" name="titulo" class="form-control" placeholder="Digite o Titulo...">
                </div>
                <br>
                <div class="form-group">
                    <label for="data">Data</label>
                    <input type="date" name="data" class="form-control" placeholder="Digite a Data...">
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
@endsection

