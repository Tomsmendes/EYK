@extends('layouts.app')

@section('title', 'Listagem de Funções')

@section('content')
<div class="container mt-5">
    <h1>Listagem de Funções</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#funcaoModal" onclick="prepareModal('create', '{{ route('funcoes.store') }}')">Nova Função</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($funcoes as $funcao)
                <tr>
                    <td>{{ $funcao->id }}</td>
                    <td>{{ $funcao->name_fc }}</td>
                    <td>{{ $funcao->descricao ?? 'Sem descrição' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#funcaoModal"
                            onclick="prepareModal('edit', '{{ route('funcoes.update', $funcao) }}', {{ json_encode($funcao) }})">Editar</button>
                        <form action="{{ route('funcoes.destroy', $funcao) }}" method="POST" class="d-inline">
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
    <div class="modal fade" id="funcaoModal" tabindex="-1" aria-labelledby="funcaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="funcaoModalLabel">Nova Função</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="funcaoForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod">
                        <div class="mb-3">
                            <label for="name_fc" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name_fc" name="name_fc" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function prepareModal(mode, url, funcao = null) {
    const form = document.getElementById('funcaoForm');
    const modalTitle = document.getElementById('funcaoModalLabel');
    const formMethod = document.getElementById('formMethod');

    form.action = url;
    form.reset();

    if (mode === 'create') {
        modalTitle.textContent = 'Nova Função';
        formMethod.value = 'POST';
    } else {
        modalTitle.textContent = 'Editar Função';
        formMethod.value = 'PUT';
        document.getElementById('name_fc').value = funcao.name_fc;
        document.getElementById('descricao').value = funcao.descricao || '';
    }
}
</script>
@endsection