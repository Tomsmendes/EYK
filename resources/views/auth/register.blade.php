<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="asset/css/auth.css">
</head>
<body>
<div class="container-login">
    <div class=logo-login><video src="asset/media/eyk-effet-panorama.mp4" autoplay loop muted playsinline  disablePictureInPicture></video>
</div>
    <div class="container">
        <h2>Criar conta</h2>
        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmação de Senha:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="role">Tipo de Usuário:</label>
                <select class="form-control" id="role" name="role">
                    <option value="student">Estudante</option>
                    <option value="teacher">Professor</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
            <div style="text-align:center;font-weight:bold;">Já possui uma conta ? <br><a href="{{ route('login') }}" class="">Entre na plataforma</a></div>
        </form>
    </div>
</div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
