<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Gabriel Canali">
    <meta name="description" content="Aplicativo de gerenciamento de jogos de RPG">
    <title>RPG Manager - Em desenvolvimento</title>
    <style>
        body { background-color: #dbdbdb; display: flex; justify-content: center; align-items: center; margin: 0; height: 100vh }
        body { font: 1.5rem Helvetica, sans-serif; color: #333 }
        h1 { font-size: 3rem }
        h2 { display: none }
        main { text-align: center; padding: 1rem }
        a { text-decoration: none; color: inherit; }
        @media screen and (max-width: 600px) {
            h1 { font-size: 2rem }
            p { font-size: 1.25rem }
        }
        @media screen and (max-width: 300px) {
            h1 { font-size: 1rem }
            p { font-size: 0.75rem }
        }
        @media screen and ((max-width: 162px) or (max-height: 300px)) {
            h1, div { display: none }
            h2 { display: block }
        }
    </style>
</head>
<body>
    <main>
        <h1>Em desenvolvimento</h1>
        <h2>☕</h2>
        <div>
            <p>Lamentamos por essa inconveniência mas este site ainda está em construção.</p>
            <p>Retorne em breve para mais <a href={{route('dashboard')}}>novidades!</a></p>
            <!-- <p>&mdash; Gabriel Canali</p> -->
        </div>
    </main>
</body>
</html>