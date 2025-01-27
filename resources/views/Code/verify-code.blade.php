<!DOCTYPE html>
<html>
<head>
    <title>Verificar Código</title>
</head>
<body>
    <h1>Introduce el código enviado</h1>
    <form method="POST" action="{{ route('verify.code.submit') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <div>
            <label for="code">Código de verificación:</label>
            <input type="text" id="code" name="code" required>
        </div>
        @if ($errors->any())
            <div>{{ $errors->first() }}</div>
        @endif
        <button type="submit">Verificar</button>
    </form>
</body>
</html>