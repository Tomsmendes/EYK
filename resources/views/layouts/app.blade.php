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

                <!-- Foto do Usuário (aleatória) -->
                <img src="https://i.pravatar.cc/40" alt="Usuário" class="rounded-circle" width="40" height="40">
            </div>
        </nav>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
