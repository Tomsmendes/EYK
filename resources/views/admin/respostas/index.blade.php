@extends('layouts.app')

@section('title', 'Listagem de Respostas')

@section('content')
<div class="container mt-5">
    <h1>Respostas da Pergunta</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Respostas</li>
        </ol>
    </nav>
    <a href="{{ route('perguntas.index') }}" class="btn btn-secondary mb-3">Voltar para Perguntas</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#respostaModal" onclick="prepareModal('create', '{{ route('respostas.store') }}')">Nova Resposta</button>

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
                <th>Texto</th>
                <th>Correta?</th>
                <th>Pergunta</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($respostas as $resposta)
                <tr>
                    <td>{{ $resposta->id }}</td>
                    <td>{{ $resposta->rp_texto }}</td>
                    <td>
                        @if ($resposta->is_correct)
                            <span class="badge bg-success">Correta</span>
                        @else
                            <span class="badge bg-danger">Errada</span>
                        @endif
                    </td>
                    <td>{{ $resposta->p_nome }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#respostaModal"
                            onclick="prepareModal('edit', '{{ route('respostas.update', [$resposta]) }}', {{ json_encode($resposta) }},)">Editar</button>
                        <form action="{{ route('respostas.destroy', [ $resposta]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta resposta?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhuma resposta cadastrada para esta pergunta.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="respostaModal" tabindex="-1" aria-labelledby="respostaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="respostaModalLabel">Nova Resposta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="respostaForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="rp_texto" class="form-label">Texto da Resposta</label>
                            <textarea class="form-control @error('rp_texto') is-invalid @enderror" id="rp_texto" name="rp_texto" required></textarea>
                            @error('rp_texto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="is_correct" class="form-label">Resposta Correta?</label>
                            <select class="form-control @error('is_correct') is-invalid @enderror" id="is_correct" name="is_correct" required>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                            @error('is_correct')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pergunta_id" class="form-label">Questionário</label>
                            <select name="pergunta_id" id="pergunta_id_id" class="form-control" required>
                                <option value="">Selecione</option>
                                @foreach ($perguntas as $pergunta)
                                    <option value="{{ $pergunta->id }}">{{ $pergunta->pg_texto }}</option>
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
function prepareModal(mode, url, resposta = null, perguntaId = null) {
    const form = document.getElementById('respostaForm');
    const modalTitle = document.getElementById('respostaModalLabel');
    const formMethod = document.getElementById('formMethod');
    const perguntaInput = document.getElementById('pergunta_id');
    const textoInput = document.getElementById('rp_texto');
    const isCorrectInput = document.getElementById('is_correct');

    form.action = url;
    form.reset();
    formMethod.value = mode === 'create' ? 'POST' : 'PUT';
    modalTitle.textContent = mode === 'create' ? 'Nova Resposta' : 'Editar Resposta';

    if (mode === 'edit' && resposta) {
        perguntaInput.value = resposta.pergunta_id;
        textoInput.value = resposta.rp_texto;
        isCorrectInput.value = resposta.is_correct;
    } else {
        perguntaInput.value = perguntaId || '';
        textoInput.value = '';
        isCorrectInput.value = '0';
    }
}
</script>
@endsection