<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eyk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        nav.sidebar {
            width: 250px;
            background-color: bisque;
            padding: 15px;
            height: 100%;
            position: relative;
            transition: transform 0.3s ease;
        }
        nav.sidebar.hidden {
            transform: translateX(-100%);
        }
        .toggle-btn {
            position: fixed;
            top: 10px;
            left: 230px;
            background: bisque;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: left 0.3s ease;
            z-index: 900;
        }
        nav.sidebar.hidden + .toggle-btn {
            left: 5px;
        }
        nav.sidebar h4 {
            margin-bottom: 20px;
        }
        nav.sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        nav.sidebar ul li a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        nav.sidebar ul li a:hover {
            background-color: #daa520;
            color: bisque;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            transition: margin-left 0.3s ease;
        }
        .content.full {
            margin-left: 0;
        }
    </style>
</head>
<body>
    <nav class="sidebar" id="sidebar">
        <h4><img src="{{ asset('media/logo-sem-fundo.png') }}" alt="logo-app"></h4>
        <ul>
            @if (auth()->user()->role === 'teacher')
                <li><a href="{{ route('admin.teacher.user.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                  </svg></a></li>
                <li><a href="{{ route('teacher.videos.index') }}">Meus Vídeos</a></li>
                <li><a href="{{ route('teacher.courses.index') }}">Meus Cursos</a></li>
                <li><a href="{{ route('teacher.videos.create') }}">Criar Vídeo</a></li>
                <li><a href="{{ route('teacher.courses.create') }}">Criar Curso</a></li>
            @elseif (auth()->user()->role === 'student')
                <li><a href="{{ route('admin.student.user.index') }}">Minha Conta</a></li>
                <li><a href="{{ route('student.videos.index') }}">Vídeos</a></li>
                <li><a href="{{ route('student.courses.index') }}">Cursos</a></li>
            @endif
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </nav>
    <button class="toggle-btn" id="toggle-btn" onclick="toggleSidebar()"><</button>
    <main class="content" id="content">
        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const toggleBtn = document.getElementById('toggle-btn');
            sidebar.classList.toggle('hidden');
            content.classList.toggle('full');
            if (sidebar.classList.contains('hidden')) {
                toggleBtn.style.left = '10px';
            } else {
                toggleBtn.style.left = '230px';
            }
        }
    </script>
</body>
</html>
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
            @yield('content')
        </div>

        <footer>
        <p>&copy; 2024 Projeto EYK - Todos os direitos reservados</p>
    </footer>
    </div>

    <style>
footer {
            color: gray;
            padding: 20px;
            text-align: center;
            margin-top: 150px;

        }

    .showPhoto img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
    </style>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
