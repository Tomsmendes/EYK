<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-6C0mKNpuOycwDpHTW9l8VLG7gUBr65EXiCvD3uvssQqmw2nn9qnFEgWy1nVS93qm" crossorigin="anonymous"></script>
  
    <title>@yield('title')</title>
    <style>
        /* Estilo para o menu */
        #sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
            display: none;
            z-index: 1000;
            padding: 20px;
        }

        /* Botão de abrir o menu */
        #toggleMenu {
            margin: 20px 20px;
            top: 20px;
            left: 20px;
            z-index: 1100;
        }

        /* Botão de fechar */
        #closeMenu {
            position: fixed;
            top: 20px;
            left: 270px; /* Largura do menu (250px) + 20px de margem */
            display: none;
            z-index: 1100;
        }

        /* Conteúdo principal */
        #content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        /* Classes para abrir o menu */
        #sidebar.show {
            display: block;
        }

        #closeMenu.show {
            display: block;
        }
        
        #content.active {
            margin-left: 250px;
        }
    </style>
</head>
<body>
    <!-- Botão para abrir o menu -->
    <button class="btn btn-primary" id="toggleMenu">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
          </svg>
    </button>

    <!-- Botão para fechar o menu -->
    <button class="btn btn-danger" id="closeMenu">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
          </svg>
    </button>

    <!-- Menu lateral -->
    <div id="sidebar">
        <h5>Menu</h5>
        <ul class="list-unstyled">
            <li><a href="{{ route('users.index') }}" class="text-decoration-none d-block py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                  </svg> Usuário</a></li>
            <li><a href="{{ route('funcoes.index') }}" class="text-decoration-none d-block py-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
              </svg> Funcões</a></li>
              <li><a href="{{ route('videos.index') }}" class="text-decoration-none d-block py-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445"/>
              </svg> Videos</a></li>
        </ul>
    </div>

    <!-- Conteúdo principal -->
    <div id="content">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <script>
        const toggleMenu = document.getElementById('toggleMenu');
        const closeMenu = document.getElementById('closeMenu');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        toggleMenu.addEventListener('click', () => {
            sidebar.classList.add('show');
            closeMenu.classList.add('show');
            content.classList.add('active');
        });

        closeMenu.addEventListener('click', () => {
            sidebar.classList.remove('show');
            closeMenu.classList.remove('show');
            content.classList.remove('active');
        });
    </script>
</body>
</html>
