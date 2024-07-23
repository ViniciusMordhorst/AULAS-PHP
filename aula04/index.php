<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segurança - Cookies</title>
    <script>
        console.log(document.cookie)
    </Script>
</head>
<body>
    <form action="Cookies.php" method="post">
        <label for="nome"> Nome: </label>
        <input type="text" name="nome" id="nome" value="<?= (isset($_COOKIE['nome'])) ? $_COOKIE['nome'] : '' ?>">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>