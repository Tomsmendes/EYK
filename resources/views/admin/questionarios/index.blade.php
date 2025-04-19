@extends('layouts.app')

@section('title', 'Listagem de Questionários')

@section('content')
<div class="container mt-5">
    <h1>Questionários da Aula</h1>
    <a href="{{ route('aulas.index') }}" class="btn btn-secondary mb-3">Voltar para Aulas</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#questionarioModal" onclick="prepareModal('create', '{{ route('questionarios.store') }}')">Novo Questionário</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Aula</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($questionarios as $questionario)
                <tr>
                    <td>{{ $questionario->id }}</td>
                    <td>{{ $questionario->qt_name }}</td>
                    <td>{{ $questionario->qt_descricao ?? 'Sem descrição' }}</td>
                    <td>{{ $questionario->a_nome }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#questionarioModal"
                            onclick="prepareModal('edit', '{{ route('questionarios.update', [$questionario]) }}', {{ json_encode($questionario) }})">Editar</button>
                        <form action="{{ route('questionarios.destroy', [$questionario]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este questionário?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum questionário cadastrado para esta aula.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="questionarioModal" tabindex="-1" aria-labelledby="questionarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionarioModalLabel">Novo Questionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="questionarioForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <div class="mb-3">
                            <label for="qt_name" class="form-label">Nome</label>
                            <input type="text" class="form-control @error('qt_name') is-invalid @enderror" id="qt_name" name="qt_name" required>
                            @error('qt_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="qt_descricao" class="form-label">Descrição</label>
                            <textarea class="form-control @error('qt_descricao') is-invalid @enderror" id="qt_descricao" name="qt_descricao"></textarea>
                            @error('qt_descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="aula_id" class="form-label">Aula</label>
                            <select class="form-control" name="aula_id" id="aula_id" required>
                                <option value="">Selecione a aula</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}">
                                        {{ $aula->title }}
                                    </option>
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
function prepareModal(mode, url, questionario = null, aulaId = null) {
    const form = document.getElementById('questionarioForm');
    const modalTitle = document.getElementById('questionarioModalLabel');
    const formMethod = document.getElementById('formMethod');
    const aulaInput = document.getElementById('aula_id');
    const nameInput = document.getElementById('qt_name');
    const descricaoInput = document.getElementById('qt_descricao');

    form.action = url;
    form.reset();

    if (mode === 'create') {
        formMethod.value = 'POST';
        modalTitle.textContent = 'Novo Questionário';
    } else {
        formMethod.value = 'PUT';
        modalTitle.textContent = 'Editar Questionário';
    }

    if (mode === 'edit' && questionario) {
        aulaInput.value = questionario.aula_id;
        nameInput.value = questionario.qt_name;
        descricaoInput.value = questionario.qt_descricao || '';
    } else {
        aulaInput.value = aulaId || '';
        nameInput.value = '';
        descricaoInput.value = '';
    }
}
</script>
@endsection
