@extends('layouts.app')

@section('title', 'Listagem de Vídeos')

@section('content')
<div class="container mt-5">
    <h1>Vídeos da Aula)</h1>
    <a href="{{ route('aulas.index') }}" class="btn btn-secondary mb-3">Voltar para Aulas</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#videoModal" onclick="prepareModal('create', '{{ route('videos.store') }}')">Novo Vídeo</button>

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
                <th>URL</th>
                <th>Descrição</th>
                <th>Aula</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($videos as $video)
                <tr>
                    <td>{{ $video->id }}</td>
                    <td>{{ $video->vd_name }}</td>
                    <td><a href="{{ $video->url }}" target="_blank">{{ $video->url }}</a></td>
                    <td>{{ $video->vd_descricao ?? 'Sem descrição' }}</td>
                    <td>{{ $video->a_nome}}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#videoModal"
                            onclick="prepareModal('edit', '{{ route('videos.update', [$video]) }}', {{ json_encode($video) }})">Editar</button>
                        <form action="{{ route('videos.destroy', [$video]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este vídeo?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum vídeo cadastrado para esta aula.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Novo Vídeo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="videoForm" method="POST">
                        @csrf
                        <div id="methodField"></div>

                        <div class="mb-3">
                            <label for="vd_name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="vd_name" name="vd_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" class="form-control" id="url" name="url" required>
                        </div>

                        <div class="mb-3">
                            <label for="vd_descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="vd_descricao" name="vd_descricao"></textarea>
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
function prepareModal(mode, url, video = null) {
    const form = document.getElementById('videoForm');
    const modalTitle = document.getElementById('videoModalLabel');
    const methodField = document.getElementById('methodField');

    form.action = url;
    form.reset();

    if (mode === 'edit' && video) {
        modalTitle.textContent = 'Editar Vídeo';
        methodField.innerHTML = '@method("PUT")';
        document.getElementById('vd_name').value = video.vd_name;
        document.getElementById('url').value = video.url;
        document.getElementById('vd_descricao').value = video.vd_descricao || '';
        document.getElementById('aula_id').value = video.aula_id;
    } else {
        modalTitle.textContent = 'Novo Vídeo';
        methodField.innerHTML = '';
    }
}
</script>
@endsection
