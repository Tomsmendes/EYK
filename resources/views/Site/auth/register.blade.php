<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="asset/css/auth.css">
    <link rel="stylesheet" href="asset/css/mediaqueryes.css">
</head>

<body>
    <div class="container-login d-flex">
        <div class="logo-login">
            <video src="asset/media/eyk-effet-panorama.mp4" autoplay loop muted playsinline disablePictureInPicture></video>
        </div>

        <div class="container mt-5">
            <h2 class="text-center">Registrar</h2>
            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="vc_nome">Nome:</label>
                    <input type="text" class="form-control" name="vc_nome" id="vc_nome" value="{{ old('vc_nome') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Senha:</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>
                <div class="form-group">
                    <label for="fc_id">Função:</label>
                    <select name="fc_id" id="fc_id" required class="form-control">
                        <option value="">Selecione uma função</option>
                        @foreach ($funcoes as $funcao)
                            <option value="{{ $funcao->id }}" {{ old('fc_id') == $funcao->id ? 'selected' : '' }}>
                                {{ $funcao->name_fc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="photo">Foto:</label>
                    <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </form>

            <div style="text-align:center; font-weight:bold;">
                Já tem uma conta? <br><a href="{{ route('login') }}">Entra gratuitamente</a>
            </div>
        </div>
    </div>
</body>
</html>
