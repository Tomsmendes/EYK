@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Editar Faq</h1>
        <hr>
        <form action="{{  route('faqs.update', ['id'=>$faqs->id]) }}" method="POST"> 
        @csrf
        @method('PUT')
            <div class="form-group">
                <div class="form-group">
                    <label for="question">Questão</label>
                    <input type="text" name="question" value="{{ $faqs->question }}" class="form-control" placeholder="Digite a Questão...">
                </div>
                <br>
                <div class="form-group">
                    <label for="answer">Resposta</label>
                    <input type="text" name="answer" class="form-control" value="{{ $faqs->answer }}" placeholder="Digite a Resposta...">
                </div>
                <br>
                <div class="form-group">
                    <label for="category_f">Categoria</label>
                    <input type="text" name="category_f" class="form-control" value="{{ $faqs->category_f }}" placeholder="Digite a Categoria...">
                </div>
                <br>
                <div class="form-group">
                    <label for="order">Resposta</label>
                    <input type="number" name="order" class="form-control" value="{{ $faqs->order }}" placeholder="Digite a Ordem...">
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
@endsection