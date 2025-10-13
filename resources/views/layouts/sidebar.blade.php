<!-- Sidebar lateral (visível apenas em telas grandes) -->
<div class="sidebar">

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="{{ asset('asset/media/logo-sem-fundo.png') }}" alt="logotipo" style="max-width: 120px;">
    </div>

    <!-- Navegação -->
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('user.index') }}">
                <i class="fa fa-users me-2"></i> Usuários
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('cursos.index') }}">
                <i class="fa fa-book me-2"></i> Cursos
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('aulas.index') }}">
                <i class="fa fa-chalkboard me-2"></i> Aulas
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('videos.create') }}">
                <i class="fa fa-video me-2"></i> Criar Vídeo
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('videos.index') }}">
                <i class="fa fa-video me-2"></i>Meus Vídeos
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('comunidade') }}">
                <i class="fa fa-comments me-2"></i> Comunidade
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('materiais.index') }}">
                <i class="fa fa-file-pdf me-2"></i> Materiais
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('questionarios.index') }}">
                <i class="fa fa-question-circle me-2"></i> Questionários
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('perguntas.index') }}">
                <i class="fa fa-question me-2"></i> Perguntas
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('respostas.index') }}">
                <i class="fa fa-check-square me-2"></i> Respostas
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-white" href="{{ route('faqs.index') }}">
                <i class="fa fa-info-circle me-2"></i> FAQs
            </a>
        </li>
    </ul>
</div>

<!-- Menu inferior (visível apenas em mobile) -->
<div class="bottom-nav">
    <a href="{{ route('user.index') }}"><i class="fa fa-users"></i></a>
    <a href="{{ route('cursos.index') }}"><i class="fa fa-book"></i></a>
    <a href="{{ route('aulas.index') }}"><i class="fa fa-chalkboard"></i></a>
    <a href="{{ route('comunidade') }}"><i class="fa fa-comments"></i></a>
    <a href="{{ route('videos.index') }}"><i class="fa fa-video"></i></a>
</div>

<!-- CSS RESPONSIVO -->
<style>
    /* Por padrão, esconde o menu inferior */
    .sidebar {
        width: 250px;
        height: 100vh;
        position: auto;
        overflow-y: auto;
        top: 0;
        left: 0;
        background-color: #ffd700;
        padding: 20px;
        box-shadow: 4px 0 6px rgba(0,0,0,0.15);
        border-right: 4px solid #c9a300;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .bottom-nav {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #ffd700;
        border-top: 4px solid #c9a300;
        height: 60px;
        justify-content: space-around;
        align-items: center;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    .bottom-nav a {
        color: white;
        font-size: 20px;
        text-align: center;
        text-decoration: none;
    }

    /* Esconde sidebar e mostra menu inferior em telas pequenas */
    @media (max-width: 768px) {
        .sidebar {
            display:none;
        }

        .bottom-nav {
            display: flex;
        }
    }
</style>

<!-- Font Awesome CDN (garanta que está no seu layout principal) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
