@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Criar Novo Usuário</h1>
        <hr>
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"> 
        @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" placeholder="Digite um nome...">
            </div>
            <br>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Digite um email...">
            </div>
            <br>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Digite uma Password...">
            </div>
            <br>
            <div class="form-group">
                <label for="fc_id">Função</label>
                <select name="fc_id" class="form-control">
                    @foreach($funcaos as $funcao)
                        <option value="{{ $funcao->id }}">{{ $funcao->name_fc }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="photo">Foto:</label>
                <input type="file" name="photo" accept=".png, .jpg, .jpeg" id="photoInput" onchange="previewImage(event)">
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
