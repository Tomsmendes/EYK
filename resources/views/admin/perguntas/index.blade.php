@extends('layouts.app')

@section('title', 'Perguntas do Questionário')

@section('content')
<div class="container mt-5">
    <h1>Perguntas</h1>
    <a href="{{ route('questionarios.index') }}" class="btn btn-secondary mb-3">Voltar para Questionários</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#perguntaModal" onclick="prepareModal('create', '{{ route('perguntas.store') }}')">Nova Pergunta</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Questionário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($perguntas as $pergunta)
                <tr>
                    <td>{{ $pergunta->id }}</td>
                    <td>{{ $pergunta->pg_texto }}</td> <!-- Corrigido para 'pg_texto' -->
                    <td>{{ $pergunta->questionario->qt_name ?? 'Sem Questionário' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#perguntaModal"
                            onclick="prepareModal('edit', '{{ route('perguntas.update', [$pergunta]) }}', {{ json_encode($pergunta) }})">Editar</button>
                        <form action="{{ route('perguntas.destroy', $pergunta->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Excluir pergunta?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Nenhuma pergunta encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="perguntaModal" tabindex="-1" aria-labelledby="perguntaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="perguntaForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="perguntaModalLabel">Nova Pergunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pg_texto" class="form-label">Texto da Pergunta</label>
                            <input type="text" name="pg_texto" id="pg_texto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="questionario_id" class="form-label">Questionário</label>
                            <select name="questionario_id" id="questionario_id" class="form-control" required>
                                <option value="">Selecione</option>
                                @foreach ($questionarios as $qt)
                                    <option value="{{ $qt->id }}">{{ $qt->qt_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function prepareModal(mode, url, pergunta = null) {
    const form = document.getElementById('perguntaForm');
    const formMethod = document.getElementById('formMethod');
    const modalTitle = document.getElementById('perguntaModalLabel');

    form.action = url;
    form.reset();

    if (mode === 'edit' && pergunta) {
        formMethod.value = 'PUT';
        modalTitle.textContent = 'Editar Pergunta';
        document.getElementById('pg_texto').value = pergunta.pg_texto;  // Corrigido para 'pg_texto'
        document.getElementById('questionario_id').value = pergunta.questionario_id;
    } else {
        formMethod.value = 'POST';
        modalTitle.textContent = 'Nova Pergunta';
    }
}
</script>
@endsection
