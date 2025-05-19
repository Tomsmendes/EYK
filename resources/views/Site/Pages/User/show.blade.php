@extends('layouts.app')

@section('title', 'Listagem de Usuários')

@section('content')
<div class="container mt-5">
    <h1>Listagem de Usuários</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal" onclick="prepareModal('create', '{{ route('user.store') }}')">
        + Adicionar Usuário
    </button>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Classe</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->vc_nome }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->vc_classe }}</td>
                        <td>{{ $user->vc_tipo }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userModal"
                                onclick="prepareModal('edit', '{{ route('user.update', $user->id) }}', {{ json_encode($user) }})">
                                <i class="bx bx-edit-alt me-1"></i> Editar
                            </button>
                            <form action="{{ route('user.delete', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">
                                    <i class="bx bx-trash me-1"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        
                        <div class="mb-3">
                            <label for="vc_nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="vc_nome" name="vc_nome" required>
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
                            <label for="vc_classe" class="form-label">Classe</label>
                            <input type="text" class="form-control" id="vc_classe" name="vc_classe">
                        </div>
                        
                        <div class="mb-3">
                            <label for="vc_tipo" class="form-label">Tipo</label>
                            <select class="form-control" id="vc_tipo" name="vc_tipo">
                                <option value="admin">Admin</option>
                                <option value="user">Usuário</option>
                                <option value="editor">Editor</option>
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
function prepareModal(mode, url, user = null) {
    const form = document.getElementById('userForm');
    const modalTitle = document.getElementById('userModalLabel');
    const formMethod = document.getElementById('formMethod');
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');

    form.action = url;
    form.reset();

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
        
        // Preenche os campos com os dados do usuário
        document.getElementById('vc_nome').value = user.vc_nome;
        document.getElementById('email').value = user.email;
        document.getElementById('vc_classe').value = user.vc_classe;
        document.getElementById('vc_tipo').value = user.vc_tipo;
    }
}
</script>

<style>
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection