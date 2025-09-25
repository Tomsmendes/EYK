@extends('layouts.nav')

@section('title', 'Comunidade | EYK')

@section('content')
    <div class="container mt-5">

        <link rel="stylesheet" href="asset/css/comunidade.css">

        <!-- Cabeçalho -->
        <header class="header-comunidade">
            <h1>
                {{-- <img class="logotype" src="{{ asset('media/maskote-semfundo.png') }}" alt=""> --}}
                Comunidade EYK
            </h1>
            <p class="subtitulo">Compartilhe o que aprendeu, jogue e interaja com outros estudantes!</p>
        </header>

        <!-- Navegação -->
        <nav class="nav-menu">
            <button class="tab-button active" data-target="feed">🧠 Feed</button>
            <button class="tab-button" data-target="jogos">🎮 Jogos</button>
            <button class="tab-button" data-target="ranking">🏆 Ranking</button>
            <button class="tab-button" data-target="conversa">💬 Bate papo</button>
        </nav>

        <main class="main-comunidade">
            <!-- Feed -->
            <section id="feed" class="section active">
                <h2>📢 O que você aprendeu hoje?</h2>
                <form action="{{ route('comunidade.store') }}" method="POST" class="form-publicacao">
                    @csrf
                    <textarea name="conteudo" rows="3" placeholder="Escreva aqui o que aprendeu..."></textarea>
                    <button type="submit">Partilhar</button>

                    @if (session('success'))
                        <div class="mensagem-sucesso">
                            {{ session('success') }}
                        </div>
                    @endif
                </form>
                <br>
                <div class="post-feed">
                    @foreach ($posts as $post)
                        <div class="post">
                            <img src="{{ $post->user && $post->user->photo
                                ? asset('uploads/' . $post->user->photo)
                                : asset('media/avatar-default.png') }}"
                                alt="Foto do usuário" class="user-avatar">

                            <div>
                                <strong>{{ $post->user->vc_nome ?? 'Usuário desconhecido' }}</strong>
                                <p>{{ $post->conteudo }}</p>

                                <!-- Botão de curtir e contagem de comentários -->
                                <div style="display: flex; align-items: center; gap: 10px; margin: 5px 0;">
                                    <form method="POST" action="{{ route('post.curtir', $post->id) }}" class="form-curtir"
                                        style="margin: 0;">
                                        @csrf
                                        <button type="submit">❤️ Curtidas ({{ $post->likes->count() }})</button>
                                    </form>

                                    <span>💬 ({{ $post->comentarios->count() }}) Comentários</span>
                                </div>

                                <!-- Comentários existentes -->
                                <div class="comentarios" id="comentarios-{{ $post->id }}">
                                    @foreach ($post->comentarios->take(2) as $comentario)
                                        <p>
                                            <strong>{{ $comentario->user->vc_nome ?? 'Anônimo' }}:</strong>
                                            {{ $comentario->conteudo }}
                                        </p>
                                    @endforeach

                                    @if ($post->comentarios->count() > 2)
                                        <div id="todos-comentarios-{{ $post->id }}" class="comentarios-ocultos">
                                            @foreach ($post->comentarios->slice(2) as $comentario)
                                                <p>
                                                    <strong>{{ $comentario->user->vc_nome ?? 'Anônimo' }}:</strong>
                                                    {{ $comentario->conteudo }}
                                                </p>
                                            @endforeach
                                        </div>

                                        <button class="btn-ver-mais" onclick="mostrarTodos({{ $post->id }})"
                                            style="margin-top: 5px; background: none; border: none; color: #007bff; cursor: pointer;">
                                            Ver mais comentários ({{ $post->comentarios->count() - 2 }})
                                        </button>

                                        <button class="btn-ver-menos" onclick="esconderTodos({{ $post->id }})"
                                            style="display: none; margin-top: 5px; background: none; border: none; color: #007bff; cursor: pointer;">
                                            Ver menos
                                        </button>
                                    @endif
                                </div>

                                <!-- Formulário de comentário -->
                                <form method="POST" action="{{ route('post.comentar', $post->id) }}"
                                    class="form-comentario">
                                    @csrf
                                    <input type="text" name="conteudo" placeholder="Escreva um comentário...">
                                    <button type="submit">Comentar</button>
                                </form>

                                <small class="data-post">{{ $post->created_at->diffForHumans() }}</small>

                                <!-- Botão apagar (só aparece para o dono) -->
                                @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">🗑️ Apagar</button>
                                    </form>
                                @endcan

                            </div>
                        </div>
                    @endforeach

                    @if ($posts->isEmpty())
                        <p class="nenhuma-publicacao">Nenhuma publicação ainda.</p>
                    @endif
                </div>
            </section>

            <!-- Jogos -->
            <section id="jogos" class="section">
                <h2>🎮 Jogos</h2>
                <div id="jogos-container"></div>
            </section>

            <!-- Ranking -->
            <section id="ranking" class="section">
                <h2>🏆 Estudantes mais ativos</h2>
                <ol>
                    <li><strong>Pedro Neto</strong> – 250 pontos</li>
                    <li><strong>Ana Mário</strong> – 210 pontos</li>
                    <li><strong>Luís Quissola</strong> – 180 pontos</li>
                </ol>
            </section>

            <!-- Conversa -->
            <section id="conversa" class="section">
                <h2>💬 Bate papo</h2>
            </section>
        </main>

        <script>
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', () => {
                    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.section').forEach(section => section.classList.remove(
                        'active'));
                    button.classList.add('active');
                    document.getElementById(button.dataset.target).classList.add('active');
                });
            });
            /*EXIBIR E RECOLHER VER MAIS*/
            function mostrarTodos(postId) {
                const container = document.getElementById(`todos-comentarios-${postId}`);
                const btnMais = document.querySelector(`#comentarios-${postId} .btn-ver-mais`);
                const btnMenos = document.querySelector(`#comentarios-${postId} .btn-ver-menos`);

                container.classList.add('ativo');
                btnMais.style.display = 'none';
                btnMenos.style.display = 'inline';
            }

            function esconderTodos(postId) {
                const container = document.getElementById(`todos-comentarios-${postId}`);
                const btnMais = document.querySelector(`#comentarios-${postId} .btn-ver-mais`);
                const btnMenos = document.querySelector(`#comentarios-${postId} .btn-ver-menos`);

                container.classList.remove('ativo');
                btnMais.style.display = 'inline';
                btnMenos.style.display = 'none';
            }
        </script>

    </div>
@endsection
