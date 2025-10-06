<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', '')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- Estilos customizados -->
  <style>
    /* Navbar */
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      padding: 10px 20px;
    }

    .navbar-nav .nav-link {
      font-weight: 500;
      color: #333 !important;
      transition: 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: goldenrod !important;
    }

    .logotype {
      height: 45px;
    }

    /* Foto do usuário */
    .showPhoto img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    /* Dropdown */
    .dropdown-menu {
      border-radius: 12px;
      padding: 8px 0;
    }

    .dropdown-item {
      transition: background 0.3s;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
    }

    /* Conteúdo */
    .content-container {
      margin-top: 80px;
      margin-bottom: 60px;
    }

    /* Footer */
    footer {
      background: #111;
      color: #ccc;
      padding: 40px 20px;
      text-align: center;
    }

    footer img {
      filter: brightness(0.9);
    }

    footer a {
      color: #ccc;
      transition: 0.3s;
    }

    footer a:hover {
      color: goldenrod;
    }

    footer p {
      margin: 6px 0;
    }

    footer hr {
      border: 0;
      height: 1px;
      background: #444;
      margin: 25px auto;
      width: 85%;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <!-- Logotipo -->
      <a class="navbar-brand" href="#">
        <img class="logotype" src="asset/media/logo-sem-fundo.png" alt="Logo EYK" />
      </a>

      <!-- Botão toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          @guest
          <li class="nav-item">
            <a class="nav-link" href="#">Comunidade</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Videos</a>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('casa.index') }}">Casa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cursos.index') }}">Cursos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('comunidade') }}">Comunidade</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('videos.public') }}">Videos</a>
          </li>
          @endguest
        </ul>

        <!-- Pesquisa -->
        <form class="d-flex mx-auto" style="max-width: 400px;">
          <input class="form-control me-2" type="search" placeholder="Pesquisar..." aria-label="Search">
          <button class="btn btn-outline-warning" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </form>

        <!-- Usuário -->
        <div class="d-flex align-items-center ms-auto">
          @auth
          <div class="dropdown">
            <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown"
              data-bs-toggle="dropdown" aria-expanded="false">
              <div class="showPhoto">
                @if (Auth::user()->photo)
                <img src="{{ url('/Uploads/' . Auth::user()->photo) }}" alt="Foto de {{ Auth::user()->vc_nome }}">
                @else
                <img src="{{ url('/media/avatar-default.png') }}" alt="Imagem padrão">
                @endif
              </div>
              <div class="text-start ms-2">
                <small class="d-block">{{ Auth::user()->vc_nome }}</small>
                <small class="text-muted">{{ Auth::user()->email }}</small>
              </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Perfil</a></li>
              <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Configurações</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
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
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Conteúdo -->
  <div class="container content-container">
  <div style="margin-bottom:8%" ></div>
    @yield('content')
  </div>

  <!-- Footer -->
  <footer>
    <div class="d-flex flex-wrap justify-content-around align-items-center gap-4 max-w-1200 mx-auto">

      <!-- Logo Projeto -->
      <div>
        <img src="asset/media/logo-sem-fundo.png" alt="Logo Projeto EYK" style="height: 60px; margin-bottom: 10px;">
        <p style="font-weight: bold;">Ekola ya kelela</p>
      </div>

      <!-- Logo Empresa -->
      <div>
        <img src="asset/media/transfortech-logo-sem-fundo.png" alt="Logo Transfortech"
          style="height: 60px; margin-bottom: 10px;">
        <p style="font-weight: bold;">Transfortech</p>
      </div>

      <!-- Links -->
      <div style="text-align: left;">
        <p><a href="/sobre.html">Sobre</a></p>
        <p><a href="/contato.html">Contato</a></p>
        <p><a href="/politica-de-privacidade.html">Política de Privacidade</a></p>
        <p><a href="/termos-de-uso.html">Termos de Uso</a></p>
        <p><a href="https://forms.gle/gTyivLDPFzc6jTU59">Quero ser Professor</a></p>
      </div>

      <!-- Redes sociais -->
      <div>
        <p>Siga-nos:</p>
        <a href="https://www.instagram.com/trans_fortech" target="_blank">
          <img src="asset/media/Instagram.png" alt="Instagram" style="height: 30px; margin: 0 5px;">
        </a>
        <a href="https://www.linkedin.com/company/transfortech" target="_blank">
          <img
            src="https://static.vecteezy.com/system/resources/previews/018/930/480/large_2x/linkedin-logo-linkedin-icon-transparent-free-png.png"
            alt="LinkedIn" style="height: 30px; margin: 0 5px;">
        </a>
      </div>
    </div>

    <hr />
    <p style="font-size: 14px;">&copy; 2025 Projeto EYK - Todos os direitos reservados a Transfortech</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
