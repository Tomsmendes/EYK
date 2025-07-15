<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
</head>
<body>
    <h1>Registrar</h1>
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
        <div>
            <label for="vc_nome">Nome:</label>
            <input type="text" name="vc_nome" id="vc_nome" value="{{ old('vc_nome') }}" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar Senha:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div>
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
        <button type="submit">Registrar</button>
    </form>
</body>
</html>