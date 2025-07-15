<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - EYK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Lobster', sans-serif;
            background-color: white;
            color: goldenrod;
        }
        .topo {
            display: flex;
        }
        .btn-E{
            text-decoration: none;
            color: #daa520;
            margin-left: 30%;
        }
        .btn-R{
            text-decoration: none;
            margin-left: 2%;
            color: #daa520;
        }

        .titlogo {
            width: 7%;
            transition: transform 0.3s ease-in-out;
        }
        .titlogo:hover {
            transform: scale(1.1); /* Animação para aumentar levemente a logo ao passar o mouse */
        }
        .search{
            padding: 1%;
            margin-top:2%;
            margin-left:5%;
            height: 35px;
            width: 40%;
            transition: 0.5s ease-in;
            border-radius: 3rem;
            border: 1px solid  gray;
            background-image: url("asset/icons/search.png");
            background-size: 20px;
            background-repeat: no-repeat;
            background-position-x: 94%;
            background-position-y: 50%;
        }
        .search:hover{
            border: 2px solid #daa520
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
        section{
            display:flex;
        }
        .sec-text{
            margin-top:5%;
        }
        .sec-text p{
            border: 2px  solid #daa520;
            border-radius: 5px;
            color:black;
            margin: 5%;
            padding:5%;
            font-weight:bold;
        }
    </style>
</head>
<body>
    <div class="topo">
        <img class="titlogo" src="asset/media/logo-sem-fundo.png" alt="Logo">
        <!--<input class="search" type="search" placeholder="Pesquisar aulas | cursos">-->
        @guest
        <!-- Botões de Entrar e Registrar -->
                <a href="{{ route('login') }}" class="btn-E" target="_blank" >Entrar</a>
                <a href="{{ route('register') }}" class="btn-R" target="_blank" >Registrar</a>
        @endguest
    </div>
<hr>
    <!-- Conteúdo da Página -->
    <div class="container text-center mt-5">
        <h1>Bem-vindo ao EYK </h1>
        <p class="lead">Estamos felizes por tê-lo aqui. Explore as funcionalidades da nossa plataforma.</p>

        <!-- Seletor de Idiomas com Ícones -->
        <div class="language-selector">
            <button><i class="fas fa-language"></i> Português</button>
            <button><i class="fas fa-handshake"></i> Libras</button>
        </div>
        <setion>
            <img style="width:80%" src="asset/media/boy-listening-music-using-laptop.jpg">
        </section>
        <section class="sec-text">
            <div><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, dolorum molestiae? Possimus odit blanditiis dolor quis cupiditate fugiat tempora, quaerat molestias eligendi dolorem ab. Consequuntur expedita dolor ducimus aperiam earum?</p></div>
            <div><p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nulla, reprehenderit maxime nesciunt saepe, vero sequi atque obcaecati similique deleniti voluptatibus labore placeat ipsum suscipit ipsa voluptatum, cum ipsam eius neque?</p></div>
            <div><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit at eveniet minima rem aliquam, perferendis cupiditate esse ullam. Delectus alias odit, repudiandae totam assumenda nihil rem voluptatem est consequuntur sit!</p></div>
        </section>

        <!-- Botões de Entrar e Registrar -->
        <div class="mt-4">
            @guest
                <a href="{{ route('login') }}" class="btn btn-custom" target="_blank" >Entrar</a>
                <a href="{{ route('register') }}" class="btn btn-custom" target="_blank" >Registrar</a>
            @else
                <h2>Olá, {{ Auth::user()->name }}!</h2>
                <a href="{{ route('admin.student.user.index') }}" class="btn btn-success">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Sair</button>
                </form>
            @endguest
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Projeto EYK - Todos os direitos reservados a transfortech</p>
        <p>
            <a href="https://www.instagram.com/trans_fortech" target="_blank">
                <img style="height: 40px;"  src="asset/media/Instagram.png" alt="Instagram">
            </a>
            <!--<a href="#">
                <img style="height: 40px;" src="asset/media//Facebook.png" alt="Facebook">
            </a>-->
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
