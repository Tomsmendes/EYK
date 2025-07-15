@extends('layouts.app')

@section('title', 'Lista de Ofensivas')

@section('content')
<div class="container mt-5">
    <h1>Lista de Ofensivas</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#ofensivaModal" onclick="prepareModal('create', '{{ route('ofensivas.store') }}')">Nova Ofensiva</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Responsável</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ofensivas as $ofensiva)
                <tr>
                    <td>{{ $ofensiva->titulo }}</td>
                    <td>{{ $ofensiva->data }}</td>
                    <td>{{ $ofensiva->descricao }}</td>
                    <td>{{ $ofensiva->user_name }}</td> <!-- Exibindo o nome do responsável -->
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ofensivaModal"
                            onclick="prepareModal('edit', '{{ route('ofensivas.update', $ofensiva) }}', {{ json_encode($ofensiva) }})">Editar</button>
                        <form action="{{ route('ofensivas.destroy', $ofensiva) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="ofensivaModal" tabindex="-1" aria-labelledby="ofensivaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="ofensivaForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ofensivaModalLabel">Nova Ofensiva</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" name="data" id="data" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Responsável</label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->vc_nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function prepareModal(mode, url, ofensiva = null) {
    const form = document.getElementById('ofensivaForm');
    const method = document.getElementById('formMethod');
    const title = document.getElementById('ofensivaModalLabel');

    form.action = url;
    form.reset();

    if (mode === 'create') {
        method.value = 'POST';
        title.textContent = 'Nova Ofensiva';
    } else {
        method.value = 'PUT';
        title.textContent = 'Editar Ofensiva';
        document.getElementById('titulo').value = ofensiva.titulo;
        document.getElementById('data').value = ofensiva.data;
        document.getElementById('descricao').value = ofensiva.descricao;
        document.getElementById('user_id').value = ofensiva.user_id; // Preenche o responsável no modal
    }
}
</script>
@endsection
