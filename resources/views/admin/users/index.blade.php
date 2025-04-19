@extends('layouts.app')

@section('title', 'Listagem de Usuários')

@section('content')
<div class="container mt-5">
    <h1>Listagem de Usuários</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal" onclick="prepareModal('create', '{{ route('users.store') }}')">Novo Usuário</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Função</th>
                <th>Foto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->funcao->name_fc ?? 'Sem função' }}</td>
                    <td>
                        <div class="showPhoto"> 
                            @if($user->photo)
                                <img src="{{ url('/uploads/'.$user->photo) }}" alt="Foto de {{ $user->name }}" class="img-thumbnail">
                            @else
                                <img src="{{ url('/uploads/default.png') }}" alt="Imagem padrão" class="img-thumbnail">
                            @endif
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userModal"
                            onclick="prepareModal('edit', '{{ route('users.update', $user) }}', {{ json_encode($user) }})">Editar</button>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
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
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Deixe em branco para não alterar a senha (edição).</small>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        <div class="mb-3">
                            <label for="fc_id" class="form-label">Função</label>
                            <select class="form-control" id="fc_id" name="fc_id">
                                <option value="">Nenhuma</option>
                                @foreach ($funcoes as $funcao)
                                    <option value="{{ $funcao->id }}">{{ $funcao->name_fc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">Foto:</label>
                            <input type="file" name="photo" accept=".png, .jpg, .jpeg" id="photoInput" onchange="previewImage(event)">
                        </div>
                        
                        <img id="photoPreview" 
                             src="#" 
                             alt="Pré-visualização da imagem" 
                             style="display: none; width: 150px; height: 150px; margin-top: 10px; border-radius: 8px; object-fit: cover;">
                        
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function prepareModal(mode, url, user = null) {
    const form = document.getElementById('userForm');
    const modalTitle = document.getElementById('userModalLabel');
    const formMethod = document.getElementById('formMethod');
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    const photoPreview = document.getElementById('photoPreview');
    const photoInput = document.getElementById('photoInput');

    form.action = url;
    form.reset();

    photoPreview.src = '#';
    photoPreview.style.display = 'none';

    if (mode === 'create') {
        modalTitle.textContent = 'Novo Usuário';
        formMethod.value = 'POST';
        passwordField.required = true;
        passwordConfirmField.required = true;
    } else {
        modalTitle.textContent = 'Editar Usuário';
        formMethod.value = 'PUT';
        passwordField.required = false;
        passwordConfirmField.required = false;
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('fc_id').value = user.fc_id || '';

        if (user && user.photo) {
            photoPreview.src = '/uploads/' + user.photo;
            photoPreview.style.display = 'block';
        }
    }

    // Limpa o input de imagem ao abrir o modal
    photoInput.value = '';
}

function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();
    
    reader.onload = function () {
        const imgElement = document.getElementById('photoPreview');
        imgElement.src = reader.result;
        imgElement.style.display = 'block'; 
    };

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
@endsection
<style>
    .showPhoto img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>