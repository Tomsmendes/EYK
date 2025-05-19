@extends('Site/layouts/page')
@section('title') Editar Usuário @endsection
@section('conteudo')

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Editar Usuário</h4>
            <p class="card-description">Atualize as informações do usuário</p>
            
            <form action="{{ route('user.update', $user->id) }}" method="POST" class="forms-sample">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="vc_nome">Nome Completo</label>
                    <input type="text" class="form-control" id="vc_nome" name="vc_nome" 
                           placeholder="Digite o nome completo" value="{{ $user->vc_nome }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Digite o email" value="{{ $user->email }}" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Deixe em branco para manter a senha atual">
                    <small class="text-muted">Preencha apenas se desejar alterar a senha</small>
                </div>
                
                <div class="form-group">
                    <label for="vc_classe">Classe</label>
                    <select class="form-control" id="vc_classe" name="vc_classe" required>
                        <option value="">Selecione uma classe</option>
                        <option value="admin" {{ $user->vc_classe == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="user" {{ $user->vc_classe == 'user' ? 'selected' : '' }}>Usuário</option>
                        <!-- Adicione outras opções conforme necessário -->
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="vc_tipo">Tipo</label>
                    <select class="form-control" id="vc_tipo" name="vc_tipo" required>
                        <option value="">Selecione um tipo</option>
                        <option value="admin" {{ $user->vc_tipo == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="normal" {{ $user->vc_tipo == 'normal' ? 'selected' : '' }}>Normal</option>
                        <!-- Adicione outras opções conforme necessário -->
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary me-2">Atualizar</button>
                    <a href="{{ route('user.all') }}" class="btn btn-light">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection