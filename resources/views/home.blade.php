<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página Inicial - EYK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    body {
      font-family: 'Lobster', sans-serif;
      background-color: white;
      color: goldenrod;
    }

    .topo {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem;
    }

    .titlogo {
      width: 80px;
      transition: transform 0.3s ease-in-out;
    }

    .titlogo:hover {
      transform: scale(1.1);
    }

    .btn-custom {
      background-color: goldenrod;
      color: white;
      border-radius: 5px;
      padding: 8px 16px;
      margin: 0 5px;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #daa520;
      transform: scale(1.05);
    }

    .language-selector {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin: 30px 0;
    }

    .language-selector button {
      background-color: goldenrod;
      border: none;
      color: white;
      padding: 10px 20px;
      font-size: 18px;
      border-radius: 5px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .language-selector button:hover {
      background-color: #daa520;
      transform: scale(1.05);
    }

    footer {
      background-color: #333;
      padding: 20px;
      color: white;
      text-align: center;
      margin-top: 50px;
    }

    footer a img {
      transition: transform 0.3s ease;
      margin: 0 10px;
    }

    footer a img:hover {
      transform: scale(1.1);
    }

    section.sec-text {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 2rem;
    }

    .sec-text p {
      border: 2px solid #daa520;
      border-radius: 8px;
      color: black;
      margin: 15px;
      padding: 20px;
      font-weight: bold;
      max-width: 300px;
      background-color: #fff9e6;
    }

    .imagem-banner {
      display: block;
      margin: 0 auto;
      width: 90%;
      border-radius: 15px;
    }

    @media (max-width: 768px) {
      .topo {
        flex-direction: column;
        align-items: flex-start;
      }
      .search {
        width: 100%;
        margin-left: 0;
      }
      .sec-text p {
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <div class="topo">
    <img class="titlogo" src="asset/media/logo-sem-fundo.png" alt="Logo EYK" />
    <!-- <input class="search" type="search" placeholder="Pesquisar aulas | cursos" /> -->

    <div>
      @guest
        <a href="{{ Route('login') }}" class="btn btn-custom">Entrar</a>
        <a href="{{ Route('register') }}" class="btn btn-custom">Registrar</a>
      @else
        <span style="color:black; font-weight:bold;">Olá, {{ Auth::user()->vc_nome }}!</span>
        <a href="{{ route('user.all') }}" class="btn btn-success">Site</a>
        <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-danger">Sair</button>
        </form>
      @endguest
    </div>
  </div>

  <hr />

  <div class="container text-center mt-5">
    <h1>Bem-vindo ao <strong>EYK</strong></h1>
    <p class="lead">Estamos felizes por tê-lo aqui. Explore as funcionalidades da nossa plataforma.</p>

    <!-- Idiomas -->
    <div class="language-selector">
      <button><i class="fas fa-language"></i> Português</button>
      <button><i class="fas fa-handshake"></i> Libras</button>
    </div>

    <img class="imagem-banner" src="asset/media/boy-listening-music-using-laptop.jpg" alt="Estudante ouvindo música usando laptop" />

    <section class="sec-text">
      <div><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, dolorum molestiae?</p></div>
      <div><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, reprehenderit maxime.</p></div>
      <div><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit at eveniet.</p></div>
    </section>
  </div>

  <footer>
    <p>&copy; 2024 Projeto EYK - Todos os direitos reservados a Transfortech</p>
    <p>
      <a href="https://www.instagram.com/trans_fortech" target="_blank" aria-label="Instagram Transfortech">
        <img style="height: 40px;" src="asset/media/Instagram.png" alt="Instagram" />
      </a>
    </p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
