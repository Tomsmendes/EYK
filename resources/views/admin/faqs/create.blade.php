@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Criar Novo FAQ</h1>
        <hr>
        <form action="{{ route('faqs.store') }}" method="POST"> 
        @csrf
            <div class="form-group">
                <div class="form-group">
                    <label for="question">Questão</label>
                    <input type="text" name="question" class="form-control" placeholder="Digite a Questão...">
                </div>
                <br>
                <div class="form-group">
                    <label for="answer">Resposta</label>
                    <input type="text" name="answer" class="form-control" placeholder="Digite a Resposta...">
                </div>
                <br>
                <div class="form-group">
                    <label for="category_f">Categoria</label>
                    <input type="text" name="category_f" class="form-control" placeholder="Digite a Categoria...">
                </div>
                <br>
                <div class="form-group">
                    <label for="order">Resposta</label>
                    <input type="number" name="order" class="form-control" placeholder="Digite a Ordem...">
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
@endsection