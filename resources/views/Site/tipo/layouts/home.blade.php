<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Inicial - EYK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="asset/css/tipo.css">
    <link rel="stylesheet" href="asset/css/mediaqueryes.css">
</head>

<body>
    <div class="landing">

         <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <!-- Logotipo -->
                <a class="navbar-brand" href="#">
                    <img class="logotype" src="asset/media/logo-sem-fundo.png" alt="Logo EYK" />
                </a>

                <!-- Botão para toggle em telas pequenas -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Conteúdo da navbar -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Links de Navegação -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="#">Comunidade</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Sobre</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="#">Casa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cursos.index') }}">Cursos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('comunidade') }}">Comunidade</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Sobre</a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Campo de Pesquisa -->
                    <form class="d-flex mx-auto" style="max-width: 400px;">
                        <input class="form-control me-2" type="search" placeholder="Pesquisar..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <!-- Usuário -->
                    <div class="d-flex align-items-center ms-auto">
                        @auth
                            <div class="dropdown">
                                <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="showPhoto">
                                        @if (Auth::user()->photo)
                                            <img src="{{ url('/Uploads/' . Auth::user()->photo) }}" alt="Foto de {{ Auth::user()->vc_nome }}" class="img-thumbnail">
                                        @else
                                            <img src="{{ url('/media/avatar-default.png') }}" alt="Imagem padrão" class="img-thumbnail">
                                        @endif
                                    </div>
                                    <div class="text-start ms-2">
                                        <small style="color: goldenrod !important;" class="d-block">{{ Auth::user()->vc_nome }}</small>
                                        <small style="color: goldenrod !important;" class="text-muted">{{ Auth::user()->email }}</small>
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
                            
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="p-4" style="margin-top:50px; margin-bottom: 50px">
        @yield('content')
    </div>
        

    <footer>
        <div
            style="display: flex; flex-wrap: wrap; justify-content: space-around; align-items: center; gap: 20px; max-width: 1200px; margin: auto;">

            <!-- Logotipo do Projeto -->
            <div>
                <img src="asset/media/logo-sem-fundo.png" alt="Logo Projeto EYK"
                    style="height: 60px; margin-bottom: 10px;">
                <p style="font-weight: bold;">Ekola ya kelela</p>
            </div>

            <!-- Logotipo da Empresa -->
            <div>
                <img src="asset/media/transfortech-logo-sem-fundo.png" alt="Logo Transfortech"
                    style="height: 60px; margin-bottom: 10px;">
                <p style="font-weight: bold;">Transfortech</p>
            </div>

            <!-- Links úteis -->
            <div style="text-align: left;">
                <p><a href="/sobre.html" style="color: #ccc; text-decoration: none;">Sobre</a></p>
                <p><a href="/contato.html" style="color: #ccc; text-decoration: none;">Contato</a></p>
                <p><a href="/politica-de-privacidade.html" style="color: #ccc; text-decoration: none;">Política de
                        Privacidade</a></p>
                <p><a href="/termos-de-uso.html" style="color: #ccc; text-decoration: none;">Termos de Uso</a></p>
            </div>

            <!-- Redes sociais -->
            <div>
                <p>Siga-nos:</p>
                <a href="https://www.instagram.com/trans_fortech" target="_blank" aria-label="Instagram Transfortech">
                    <img src="asset/media/Instagram.png" alt="Instagram" style="height: 30px; margin: 0 5px;">
                </a>
                <a href="https://www.linkedin.com/company/transfortech" target="_blank"
                    aria-label="LinkedIn Transfortech">
                    <img src="https://static.vecteezy.com/system/resources/previews/018/930/480/large_2x/linkedin-logo-linkedin-icon-transparent-free-png.png"
                        alt="LinkedIn" style="height: 30px; margin: 0 5px;">
                </a>
            </div>
        </div>

        <hr style="margin: 30px auto; border: 0; height: 1px; background: #444; width: 90%;" />
        <p style="font-size: 14px;">&copy; 2025 Projeto EYK - Todos os direitos reservados a Transfortech</p>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
