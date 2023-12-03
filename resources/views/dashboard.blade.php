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
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .user-info img {
            max-width: 800px;
        }
    </style>
</head>
<body>
    <main>
        <h1>Dashboard</h1>
        <div class="user-info">
            @if ($user = Auth::user())
                @if ($user->profile_image)
                    <img src="{{ asset('profile-images/'.$user->profile_image) }}" alt="Profile Image">
                @endif
                {{ $user }}
                <a href="{{ route('logout') }}">Deslogar</a>
            @endif
        </div>
    </main>
</body>
</html>