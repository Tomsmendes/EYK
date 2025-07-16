<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
</head>
 <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="asset/css/auth.css">
<body>
    <div class="container-login">
         <div class=logo-login><video src="asset/media/eyk-effet-panorama.mp4" autoplay loop muted playsinline disablePictureInPicture ></video></div>
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
        <div class="form-group" >
            <label for="vc_nome">Nome:</label>
            <input type="text" class="form-control" name="vc_nome" id="vc_nome" value="{{ old('vc_nome') }}" required>
        </div>
        <div class="form-group" >
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group" >
            <label for="password">Senha:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group" >
            <label for="password_confirmation">Confirmar Senha:</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div class="form-group" >
            <label for="fc_id">Função:</label>
            <select name="fc_id" id="fc_id" required>
                <option value="">Selecione uma função</option>
                @foreach ($funcoes as $funcao)
                    <option value="{{ $funcao->id }}" {{ old('fc_id') == $funcao->id ? 'selected' : '' }}>
                        {{ $funcao->name_fc }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="photo">Foto:</label>
            <input type="file" name="photo" id="photo" accept="image/*">
        </div>
        <button type="submit"class="btn btn-primary">Registrar</button>
    </form>
        </div>
    </div>
</body>
</html>
