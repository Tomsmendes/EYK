@extends('Site.tipo.layouts.home')

@section('title', 'Upload de Vídeo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white text-center py-3 rounded-top-4" 
                     style="background: linear-gradient(90deg, #b8860b, #ffd700);">
                    <h3 class="mb-0 fw-bold">🎥 Enviar Novo Vídeo</h3>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('videos.store') }}" method="POST" id="uploadForm" enctype="multipart/form-data">
                        @csrf

                        <!-- Campo oculto com o ID da aula -->
                        <input type="hidden" name="aula_id" value="{{ request('aula_id') }}">

                        <!-- Título -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Título do Vídeo:</label>
                            <input type="text" name="titulo" class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   placeholder="Digite o título do vídeo" required>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Descrição:</label>
                            <textarea name="descricao" rows="3" class="form-control rounded-3 shadow-sm border-warning"
                                      placeholder="Fale um pouco sobre o conteúdo do vídeo"></textarea>
                        </div>

                        <!-- Vídeo -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Arquivo de Vídeo (MP4 / WebM):</label>
                            <input type="file" name="video" id="videoFile" 
                                   class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   accept="video/*" required onchange="updateProgress()">

                            <div class="progress mt-3" id="progressBar" style="display:none; height: 25px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                     id="progress" style="width:0%; background-color: #ffd700; color: #000; font-weight:bold;">
                                    0%
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Thumbnail (opcional):</label>
                            <input type="file" name="thumbnail" 
                                   class="form-control form-control-lg rounded-3 shadow-sm border-warning" 
                                   accept="image/*">
                            <small class="text-muted">Se não enviar, uma miniatura será gerada automaticamente.</small>
                        </div>

                        <!-- Botão -->
                        <div class="text-center mt-4">
                            <button type="submit" 
                                    class="btn btn-lg px-5 shadow-sm rounded-3 text-dark fw-bold"
                                    style="background: linear-gradient(90deg, #ffd700, #b8860b); border: none;">
                                <i class="bi bi-upload"></i> Enviar Vídeo
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center bg-light rounded-bottom-4 py-3">
                    <small class="text-muted">Tamanho máximo permitido: <strong>500MB</strong></small>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Script de upload -->
<script>
function updateProgress() {
    const file = document.getElementById('videoFile').files[0];
    if (file && file.size > 500 * 1024 * 1024) {
        alert('⚠️ O vídeo é muito grande! O máximo permitido é 500MB.');
        document.getElementById('videoFile').value = "";
        return;
    }
    document.getElementById('progressBar').style.display = 'block';
}

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const percent = (e.loaded / e.total) * 100;
            document.getElementById('progress').style.width = percent + '%';
            document.getElementById('progress').textContent = Math.round(percent) + '%';
        }
    };

    xhr.onload = function() {
        if (xhr.status === 200) {
            window.location = "{{ route('videos.index') }}";
        } else {
            alert('❌ Ocorreu um erro durante o upload.');
        }
    };

    xhr.send(formData);
});
</script>
@endsection
