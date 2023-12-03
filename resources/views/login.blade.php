<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Gabriel Canali">
    <meta name="description" content="Aplicativo de gerenciamento de jogos de RPG">
    <title>RPG Manager - Em desenvolvimento</title>
    <style>
        body { background-color: #dbdbdb; display: flex; justify-content: center; align-items: center; margin: 0; height: 100vh; }
        body { font: 1.5rem Helvetica, sans-serif; color: #333; }
        h1 { font-size: 3rem; }
        main { text-align: center;  }
        @media screen and (max-width: 400px) {
            h1 { display: none; }
        }
        main > form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 500px;
        }
        main > form > * {
            margin: 1rem;
            padding: 0.5rem;
            width: 100%;
            border: none;
            border-radius: 0.5rem;
        }
        main > form > button {
            border: 1px solid #c4c4c4;
            border-radius: 0.3rem;
            cursor: pointer;
        }
        main > form > button:hover {
            background-color: #e0dfdf;
        }
    </style>
</head>
<body>
    <main>
        <h1>Login</h1>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <form action="{{ route('authenticate') }}" method="post">
            @csrf <!-- {{ csrf_field() }} -->
            <input type="text" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" id="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </main>
</body>
</html>