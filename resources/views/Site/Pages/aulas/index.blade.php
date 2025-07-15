@extends('layouts.app')

@section('title', 'Listagem de Aulas')

@section('content')
<div class="container mt-5">
    <h1>Lista de Aulas</h1>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#aulaModal" onclick="prepareModal('create', '{{ route('aulas.store') }}')">
        Nova Aula
    </button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Ordem</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aulas as $aula)
                <tr>
                    <td>{{ $aula->id }}</td>
                    <td>{{ $aula->title }}</td>
                    <td>{{ $aula->order }}</td>
                    <td>{{ $aula->curso_description }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#aulaModal"
                            onclick="prepareModal('edit', '{{ route('aulas.update', $aula) }}', {{ json_encode($aula) }})">
                            Editar
                        </button>
                        <form action="{{ route('aulas.destroy', $aula) }}" method="POST" class="d-inline">
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
    <div class="modal fade" id="aulaModal" tabindex="-1" aria-labelledby="aulaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aulaModalLabel">Nova Aula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="aulaForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Ordem</label>
                            <input type="number" class="form-control" id="order" name="order" required>
                        </div>

                        <div class="mb-3">
                            <label for="curso_id" class="form-label">Curso</label>
                            <select class="form-control" name="curso_id" id="curso_id" required>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}">{{ $curso->description }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function prepareModal(mode, url, aula = null) {
    const form = document.getElementById('aulaForm');
    const modalTitle = document.getElementById('aulaModalLabel');
    const formMethod = document.getElementById('formMethod');

    form.action = url;
    form.reset();

    if (mode === 'create') {
        modalTitle.textContent = 'Nova Aula';
        formMethod.value = 'POST';
    } else {
        modalTitle.textContent = 'Editar Aula';
        formMethod.value = 'PUT';
        document.getElementById('title').value = aula.title;
        document.getElementById('description').value = aula.description || '';
        document.getElementById('order').value = aula.order;
        document.getElementById('curso_id').value = aula.curso_id;
    }
}
</script>
@endsection
