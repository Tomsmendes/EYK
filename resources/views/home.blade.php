<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Inicial - EYK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="asset/css/home.css">
    <link rel="stylesheet" href="asset/css/mediaqueryes.css">
</head>
<style>
    .landing {
        padding: 1rem;
        background-image: url('{{ ' asset/Website-ui-img/landing.png' }}');
        width: 100%;
        height: 100%;
        background-size: 100%;
        background-repeat: no-repeat;
    }
</style>

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
                                <a class="nav-link" href="{{ route('videos.public') }}">Videos</a>
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
                                <a class="nav-link" href="{{ route('videos.public') }}">Videos</a>
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

        <div class="welcome">
            <br>
            <br>
            <br>
            <h1>Estudar Língua Gestual <br><span style="color: goldenrod;">Online</span> nunca foi tão fácil</h1>
            <q>Ekola ya kelela, uma plataforma dedicada para o ensino especial.</q><br><br>
            <div>
                @guest
                    <a href="{{ Route('login') }}" class="btn btn-custom" id="entrar" target="_blank">Entrar</a>
                    <a href="{{ Route('register') }}" class="btn btn-custom" target="_blank">Registar</a>
                @else

                @endguest
            </div>
        </div>
    </div>

    <div class="container text-center mt-5">
        <h1>O que é <strong>EYK?</strong></h1>
        <p class="lead">Ekola ya kelela de origem Kimbundu, em Português <q>Escola Especial</q>,é uma plataforma
            digital direcionada à pessoas com deficiências aufónicas e auditivas, ajudando-ás com vídeo-aulas, conteúdos
            de entretenimento, conceitos escolares e científicos, de modo a reforçar o seu entendimento sobre conteúdos
            já ministrados e também esclarecendo dúvidas.Eyk vem oferecendo oportunidades tanto para professores quanto
            para estudantes criando um ambiente educacional dinâmico onde professores possam compartilhar suas aulas
            online, e usuários possam acessar conteúdos de qualidade em diversos temas educacionais.
        </p>
        <div class="login-lead" >
            @guest
                <a href="{{ Route('login') }}" class="btn btn-custom" id="entrar" >Entrar</a>
                <a href="{{ Route('register') }}" class="btn btn-custom" >Registar</a>
            @else
                <span style="color:white; font-weight:bold;">Olá, {{ Auth::user()->vc_nome }}!</span>
                <a href="{{ route('user.all') }}" class="btn btn-success">Site</a>
                <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Sair</button>
                </form>
            @endguest
        </div>

        <div class="estdprof">
            <img src="asset/media/estudante.jpg" alt="">
            <img src="asset/media/prof.jpg" alt="">
        </div><br>
        <div class="container-maskote">
            <h2>Nesta jornada você será acompanhado pelos nossos amigos</h2><br>
            <img src=" asset/Website-ui-img/maskote.png"alt="imagem maskote">
        </div>
        <br>
        <h2>O que torna a <span style="color: blue">plataforma</span> única?</h2>
        <section class="sec-text">
            <div>
                <h3><i class="fas fa-globe"></i> Acessível</h3>
                <p>Alunos podem estudar a qualquer momento e de qualquer lugar desde que esteja conectado à
                    internet.<br>
                </p>
            </div>
            <div>
                <h3><i class="fas fa-bolt"></i> Eficiência</h3>
                <p>Reduz custos com materiais físicos e otimiza o tempo de ensino.</p>
            </div>
            <div>
                <h3><i class="fas fa-gift"></i> Grátis</h3>
                <p>Para todos os níveis de ensino que buscam aprender sobre temas específicos, de forma gratuita.</p>
            </div>
        </section>
        <br>
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
