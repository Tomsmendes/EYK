<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Educação Online')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome para Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content" style="margin-left: 250px;">
        <!-- NAVBAR SUPERIOR -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-2 d-flex justify-content-between align-items-center">
            <form class="d-flex w-50">
                <input class="form-control me-2" type="search" placeholder="Pesquisar..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>

            <div class="d-flex align-items-center">
                <!-- Notificações -->
                <a href="#" class="text-dark me-4 position-relative">
                    <i class="fa fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>
                </a>

                <!-- Informações do Usuário Logado -->
                @auth
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="showPhoto">
                            @if (Auth::user()->photo)
                                <img src="{{ url('/Uploads/' . Auth::user()->photo) }}" alt="Foto de {{ Auth::user()->vc_nome }}" class="img-thumbnail">
                            @else
                                <img src="{{ url('/Uploads/default.png') }}" alt="Imagem padrão" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="text-start">
                            <small class="d-block">{{ Auth::user()->vc_nome }}</small>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Configurações</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Entrar</a>
                @endauth
            </div>
        </nav>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="p-4">
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

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>