@extends('Site.tipo.layouts.home')

@section('title', 'Criar Novo Curso')

@section('content')
<div class="container mt-5">
    <h1 class="text-center fw-bold mb-4" style="color: gold;">Criar Novo Curso</h1>

    <div class="text-center mb-4">
        <a href="{{ route('cursos.index') }}" 
           class="btn fw-bold px-4 py-2" 
           style="background-color: gold; color: white; border-radius: 25px; box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3); transition: 0.3s;">
            Voltar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success text-center fw-semibold" style="background-color: #fff8e1; color: #c79a00; border: 1px solid gold;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                <!-- Coluna Esquerda -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name_curso" class="form-label fw-bold text-dark">Nome do Curso</label>
                        <input type="text" class="form-control" id="name_curso" name="name_curso" value="{{ old('name_curso') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold text-dark">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-bold text-dark">Categoria</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" required>
                    </div>
                </div>

                <!-- Coluna Direita -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_id" class="form-label fw-bold text-dark">Usuário</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">Selecione um usuário</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->vc_nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold text-dark">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="ativo" {{ old('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label fw-bold text-dark">Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" 
                            class="btn fw-bold px-5 py-2"
                            style="background-color: gold; color: white; border-radius: 25px; box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3); transition: 0.3s;">
                        Criar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: gold;
        box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
    }
    .btn:hover {
        background-color: darkgoldenrod !important;
        transform: scale(1.05);
    }
</style>
@endsection
