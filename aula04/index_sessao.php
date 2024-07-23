<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segurança - Sessão</title>
</head>

<body>
    <form action="sessao.php" method="post">
        <label for="nome"> Nome: </label>
        <input type="text" name="nome" id="nome" value="" ?>
        <button type="submit">Enviar</button>
    </form>
    <a href="destruir_sessao.php">Destruir sessão</a>
    <p>Nome: <?=$_SESSION['nome']?> </p>

</body>
</html>

// http://127.0.0.1/ifpr/aula04/index_sessao.php //