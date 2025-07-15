<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Projeto EYK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Lobster', sans-serif;
            background-color: white;
            color: goldenrod;
        }
        /* Centralizando a logo no topo */
        .topo {
            display: flex;
            justify-content: center;
            background-color: white;
            padding: 20px;
            box-shadow: 5px 5px 5px black;
        }
        .titlogo {
            width: 150px;
            transition: transform 0.3s ease-in-out;
        }
        .titlogo:hover {
            transform: scale(1.1); /* Animação para aumentar levemente a logo ao passar o mouse */
        }
        /* Estilos do vídeo */
        .mov-boasvindas {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }
        .mov-boasvindas video {
            width: 80%;
            max-width: 720px; /* Limite para não estourar a tela em resoluções grandes */
            border: 5px solid goldenrod;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .mov-boasvindas video:hover {
            transform: scale(1.02); /* Efeito hover no vídeo */
        }
        /* Estilos dos botões */
        .btn-custom {
            margin: 10px;
            padding: 10px 20px;
            background-color: goldenrod;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #daa520;
            transform: scale(1.05); /* Efeito de crescimento suave ao passar o mouse */
        }
        /* Seletor de idiomas */
        .language-selector {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .language-selector button {
            background-color: goldenrod;
            border: none;
            color: white;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .language-selector button:hover {
            background-color: #daa520;
            transform: scale(1.05); /* Aumenta o botão ao passar o mouse */
        }
        /* Rodapé */
        footer {
            background-color: gray;
            padding: 20px;
            color: white;
            text-align: center;
            margin-top: 50px;
        }
        footer a img {
            transition: transform 0.3s ease;
        }
        footer a img:hover {
            transform: scale(1.1); /* Efeito hover nos ícones do rodapé */
        }
    </style>
</head>
<body>

    <!-- Topo com Logo Centralizada -->
    <div class="topo">
        <img class="titlogo" src="asset/media/logo.png" alt="Logo"> <!-- Ajuste para garantir que a logo seja carregada -->
    </div>

    <!-- Conteúdo da Página -->
    <div class="container text-center mt-5">
        <h1>Bem-vindo ao Projeto EYK</h1>
        <p class="lead">Estamos felizes por tê-lo aqui. Explore as funcionalidades da nossa plataforma.</p>

        <!-- Seletor de Idiomas com Ícones -->
        <div class="language-selector">
            <button><i class="fas fa-language"></i> Português</button>
            <button><i class="fas fa-handshake"></i> Libras</button>
        </div>

        <!-- Vídeo de Boas-vindas MP4 -->
        <div class="mov-boasvindas">
            <video src="asset/media/ana.mp4" controls controlsList="nodownload"></video> <!-- Ajuste para garantir o vídeo correto -->
        </div>

        <!-- Botões de Entrar e Registrar -->
        <div class="mt-4">
            @guest
                <a href="{{ Route('login') }}" class="btn btn-custom">Entrar</a>
                <a href="{{ Route('register') }}" class="btn btn-custom">Registrar</a>
            @else
                <h2>Olá, {{ Auth::user()->vc_nome }}!</h2>
                <a href="{{ route('user.all') }}" class="btn btn-success">Site</a>
                <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Sair</button>
                </form>
            @endguest
        </div>
    </div>

    
    <footer>
        <p>&copy; 2024 Projeto EYK - Todos os direitos reservados</p>
        <p>
            <a href="https://www.instagram.com/trans_fortech" target="_blank">
                <img style="height: 40px;"  src="asset/media/Instagram.png" alt="Instagram">
            </a>
            <a href="#">
                <img style="height: 40px;" src="asset/media//Facebook.png" alt="Facebook">
            </a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
