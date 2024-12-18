<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclua o Bootstrap para estilização -->
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
            padding: 20px;
            height: 100%;
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
        }
    </style>
</head>
<body>

  
        <!-- Sidebar -->
    <nav class="sidebar">
        <h4>EYK</h4>
        <ul>
            @if (auth()->user()->role === 'teacher')
                <li><a href="{{ route('admin.teacher.user.index') }}">Minha Conta</a></li>
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
  

    <!-- Área de Conteúdo Principal -->
    <main class="col-md-9">
        @yield('content')
    </main>

    <!-- Scripts do Laravel e Bootstrap -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
