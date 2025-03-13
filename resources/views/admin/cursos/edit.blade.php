@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Editar Curso</h1>
        <hr>
        <form action="{{ route('cursos.update', ['id' => $cursos->id]) }}" method="POST" enctype="multipart/form-data"> 
        @csrf
        @method('PUT')
            <div class="form-group">
                <label for="category">Categoria</label>
                <input type="text" name="category" value="{{ $cursos->category }}" class="form-control" placeholder="Digite uma Categoria...">
            </div>
            <br>
            <div class="form-group">
                <label for="status">Função</label>
                <select name="status" class="form-control">
                    <option value="draft">Rascunho</option>
                    <option value="published">Publicado</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="price">Preço</label>
                <input type="number" step="0.01" name="price" value="{{ $cursos->price }}" class="form-control" placeholder="Digite um Preço...">
            </div>
            <br>
            <div class="form-group">
                <label for="duration">Duração</label>
                <input type="text"  name="duration" value="{{ $cursos->duration }}" class="form-control" placeholder="Digite a Duração...">
            </div>
            <br>
            <div class="form-group">
                <label for="thumbnail">Foto:</label>
                <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg" id="photoInput" onchange="previewImage(event)">
            </div>
            
            <img id="photoPreview" 
                src="{{ url('/uploads/'.$cursos->thumbnail) }}" 
                alt="Pré-visualização da imagem" 
                style="display: {{ $cursos->thumbnail ? 'block' : 'none' }}; width: 150px; height: 150px; margin-top: 10px;">
            
            <br>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="Atualizar">
            </div>
        </form>
    </div>
@endsection

<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        var preview = document.getElementById("photoPreview");

        reader.onload = function() {
            preview.src = reader.result;
            preview.style.display = "block";
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


