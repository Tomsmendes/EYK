@extends('layouts.app')

@section('title', 'Listagem de Usuários')

@section('content')
    @auth
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <div class="flex-shrink-0 me-3">
                <i class="fas fa-user-circle fa-2x"></i>
            </div>
            <div>
                <h5 class="alert-heading mb-1">Bem-vindo, {{ Auth::user()->vc_nome }}!</h5>
                <p class="mb-0">Você está logado como <strong>{{ Auth::user()->email }}</strong></p>
            </div>
        </div>
    @endauth

    <div class="container mt-5">
        <h1>Listagem de Usuários</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal"
                onclick="prepareModal('create', '{{ route('user.store') }}')">
            + Adicionar Usuário
        </button>

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-dark">
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
                                <td>{{ $user->vc_nome }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->funcao->name_fc ?? 'Sem função' }}</td>
                                <td>
                                    <div class="showPhoto">
                                        @if ($user->photo)
                                            <img src="{{ url('/Uploads/' . $user->photo) }}" alt="Foto de {{ $user->vc_nome }}" class="img-thumbnail">
                                        @else
                                            <img src="{{ url('/Uploads/default.png') }}" alt="Imagem padrão" class="img-thumbnail">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userModal"
                                        onclick="prepareModal('edit', '{{ route('user.update', $user->id) }}', {!! json_encode([
                                            'id' => $user->id,
                                            'vc_nome' => $user->vc_nome,
                                            'email' => $user->email,
                                            'fc_id' => $user->fc_id,
                                            'photo' => $user->photo,
                                        ]) !!})">
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
                        <form id="userForm" method="POST" enctype="multipart/form-data">
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
                                <label for="fc_id" class="form-label">Função</label>
                                <select class="form-control" id="fc_id" name="fc_id" required>
                                    <option value="">Selecione uma função</option>
                                    @foreach ($funcoes as $funcao)
                                        <option value="{{ $funcao->id }}">{{ $funcao->name_fc }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" class="form-control" name="photo" id="photoInput" accept=".png,.jpg,.jpeg" onchange="previewImage(event)">
                            </div>

                            <img id="photoPreview" src="#" alt="Pré-visualização da imagem"
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

                if (user) {
                    document.getElementById('vc_nome').value = user.vc_nome || '';
                    document.getElementById('email').value = user.email || '';
                    document.getElementById('fc_id').value = user.fc_id || '';

                    if (user.photo) {
                        photoPreview.src = '/Uploads/' + user.photo;
                        photoPreview.style.display = 'block';
                    }
                }
            }

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
