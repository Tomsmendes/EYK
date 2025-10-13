@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Simples de Vídeo (até 500MB)</h2>
    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Vídeo</label>
        <input type="file" name="video" class="form-control" required>
    </div>

    {{-- Campo oculto com ID da aula (se existir) --}}
    @if(isset($aulaId))
        <input type="hidden" name="aula_id" value="{{ $aulaId }}">
    @else
        <div class="form-group">
            <label>Aula</label>
            <select name="aula_id" class="form-control">
                <option value="">-- Selecione a aula --</option>
                @foreach($aulas as $aula)
                    <option value="{{ $aula->id }}">{{ $aula->titulo }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <button type="submit" class="btn btn-success mt-3">Salvar</button>
</form>
</div>

<script>
function updateProgress() {
    const file = document.getElementById('videoFile').files[0];
    if (file && file.size > 500 * 1024 * 1024) {
        alert('Vídeo muito grande! Máx 500MB.');
        return;
    }
    document.getElementById('progressBar').style.display = 'block';
}

// Progresso no submit (simples, via XMLHttpRequest)
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const percent = (e.loaded / e.total) * 100;
            document.getElementById('progress').style.width = percent + '%';
            document.getElementById('progressText').textContent = Math.round(percent) + '%';
        }
    };

    xhr.onload = function() {
        if (xhr.status === 200) {
            window.location = "{{ route('videos.index') }}";
        } else {
            alert('Erro no upload.');
        }
    };

    xhr.send(formData);
});
</script>
@endsection