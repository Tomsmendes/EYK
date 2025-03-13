@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Criar Novo Curso</h1>
        <hr>
        <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data"> 
        @csrf
            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" class="form-control" placeholder="Digite uma categoria...">
            </div>
            <br>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="draft">Rascunho</option>
                    <option value="published">Publicado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Preço</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Digite um Preço...">
            </div>
            <br>
            <div class="form-group">
                <label for="duration">Password</label>
                <input type="text" name="duration" class="form-control" placeholder="Digite uma Duração...">
            </div>
            <br>
            <br>
            <div class="form-group">
                <label for="thumbnail">Foto:</label>
                <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg" id="photoInput" onchange="previewImage(event)">
            </div>
            <img id="photoPreview" src="#" alt="Pré-visualização da imagem" style="display: none; width: 150px; height: 150px; margin-top: 10px;">            
            <br>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
@endsection
<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        
        reader.onload = function(){
            var imgElement = document.getElementById('photoPreview');
            imgElement.src = reader.result;
            imgElement.style.display = 'block'; 
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
