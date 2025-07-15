@extends('layouts.app')

@section('title', 'Listagem de Cursos')

@section('content')
<div class="container mt-5">
    <h1>Listagem de Cursos</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#cursoModal" onclick="prepareModal('create', '{{ route('cursos.store') }}')">Novo Curso</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Duração</th>
                <th>Usuário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
                <tr>
                    <td>{{ $curso->id }}</td>
                    <td>{{ $curso->description }}</td>
                    <td>{{ $curso->category }}</td>
                    <td>{{ number_format($curso->price, 2, ',', '.') }}</td>
                    <td>{{ $curso->duration }} min</td>
                    <td>{{ $curso->user_name }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#cursoModal"
                            onclick="prepareModal('edit', '{{ route('cursos.update', $curso) }}', {{ json_encode($curso) }})">Editar</button>
                        <form action="{{ route('cursos.destroy', $curso) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="cursoModal" tabindex="-1" aria-labelledby="cursoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="cursoForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cursoModalLabel">Novo Curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Usuário</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">Selecione um usuário</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->vc_nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Data de Publicação</label>
                            <input type="date" class="form-control" id="published_at" name="published_at">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Preço</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01">
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Duração</label>
                            <input type="text" class="form-control" id="duration" name="duration">
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewThumbnail(event)">
                        </div>

                        <div class="mb-3 text-center">
                            <img id="thumbnailPreview" src="#" alt="Pré-visualização da thumbnail" style="display: none; width: 150px; height: auto;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para preview e edição -->
    <script>
    function prepareModal(mode, url, curso = null) {
        const form = document.getElementById('cursoForm');
        const modalTitle = document.getElementById('cursoModalLabel');
        const formMethod = document.getElementById('formMethod');
        const preview = document.getElementById('thumbnailPreview');

        form.action = url;
        form.reset();
        preview.style.display = 'none';
        preview.src = "#";

        if (mode === 'create') {
            modalTitle.textContent = 'Novo Curso';
            formMethod.value = 'POST';
        } else {
            modalTitle.textContent = 'Editar Curso';
            formMethod.value = 'PUT';

            document.getElementById('user_id').value = curso.user_id;
            document.getElementById('description').value = curso.description;
            document.getElementById('category').value = curso.category;
            document.getElementById('status').value = curso.status;
            document.getElementById('published_at').value = curso.published_at ? curso.published_at.split(' ')[0] : '';
            document.getElementById('price').value = curso.price;
            document.getElementById('duration').value = curso.duration;

            if (curso.thumbnail) {
                preview.src = `/uploads/cursos/${curso.thumbnail}`;
                preview.style.display = 'block';
            }
        }
    }

    function previewThumbnail(event) {
        const input = event.target;
        const preview = document.getElementById('thumbnailPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</div>
@endsection