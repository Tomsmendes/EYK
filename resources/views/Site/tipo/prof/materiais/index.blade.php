@extends('layouts.app')

@section('title', 'Listagem de Materiais')

@section('content')
<div class="container mt-5">
    <h1>Materiais da Aula</h1>
    <a href="{{ route('aulas.index') }}" class="btn btn-secondary mb-3">Voltar para Aulas</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#materialModal" onclick="prepareModal('create', '{{ route('materiais.store') }}')">Novo Material</button>

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
                <th>Arquivo</th>
                <th>Descrição</th>
                <th>Aula</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($materiais as $material)
                <tr>
                    <td>{{ $material->id }}</td>
                    <td>{{ $material->mt_name }}</td>
                    <td><a href="{{ asset('storage/' . $material->url) }}" target="_blank">Download</a></td>
                    <td>{{ $material->mt_descricao ?? 'Sem descrição' }}</td>
                    <td>{{ $material->a_nome }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#materialModal"
                            onclick="prepareModal('edit', '{{ route('materiais.update', [$material]) }}', {{ json_encode($material) }})">Editar</button>
                        <form action="{{ route('materiais.destroy', [$material]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este material?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum material cadastrado para esta aula.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materialModalLabel">Novo Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="materialForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <div class="mb-3">
                            <label for="mt_name" class="form-label">Nome</label>
                            <input type="text" class="form-control @error('mt_name') is-invalid @enderror" id="mt_name" name="mt_name" required>
                            @error('mt_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">Arquivo (PDF, DOC, DOCX)</label>
                            <input type="file" class="form-control @error('url') is-invalid @enderror" id="url" name="url" accept=".pdf,.doc,.docx">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mt_descricao" class="form-label">Descrição</label>
                            <textarea class="form-control @error('mt_descricao') is-invalid @enderror" id="mt_descricao" name="mt_descricao"></textarea>
                            @error('mt_descricao')
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
function prepareModal(mode, url, material = null, aulaId = null) {
    const form = document.getElementById('materialForm');
    const modalTitle = document.getElementById('materialModalLabel');
    const formMethod = document.getElementById('formMethod');
    const aulaInput = document.getElementById('aula_id');
    const nameInput = document.getElementById('mt_name');
    const descricaoInput = document.getElementById('mt_descricao');

    form.reset(); // Limpa antes de preencher
    form.action = url;
    formMethod.value = mode === 'create' ? 'POST' : 'PUT';
    modalTitle.textContent = mode === 'create' ? 'Novo Material' : 'Editar Material';

    if (mode === 'edit' && material) {
        aulaInput.value = material.aula_id;
        nameInput.value = material.mt_name;
        descricaoInput.value = material.mt_descricao ?? '';
    } else {
        aulaInput.value = aulaId ?? '';
        nameInput.value = '';
        descricaoInput.value = '';
    }
}
</script>
@endsection
