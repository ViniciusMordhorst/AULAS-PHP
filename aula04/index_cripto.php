<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segurança -Criptografia</title>
</head>
<body>
    <h1>Criptografia de senha</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="senha"> Senha: </label>
        <input type="text" name="senha" id="senha" value="<?= (isset($_POST['senha'])) ? $_POST['senha'] : '' ?>">
        <button type="submit">Enviar</button>
    </form>
<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $senha = $_POST['senha'];
        $md5senha = md5($senha);
        $sha1senha = sha1($senha);
        $hashsenha = password_hash($senha, PASSWORD_DEFAULT);
    
?>
    <p><b>MD5: </b><?=$md5senha?></p>
    <p><b>SHA1: </b><?=$sha1senha?></p>
    <p><b>PASSWORD_HASH: </b><?=$hashsenha?></p>
    
<?php } ?>

<h1>Verificar Senha</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <input type="hidden" name="md5senha" value="<?=$md5senha?>">
    <input type="hidden" name="sha1senha" value="<?=$sha1senha?>">
    <input type="hidden" name="hashsenha" value="<?=$hashsenha?>">


        <label for="csenha"> Senha: </label>
        <input type="text" name="csenha" id="csenha" value="<?= (isset($_POST['csenha'])) ? $_POST['csenha'] : '' ?>">
        <button type="submit">Enviar</button>
    </form>
<?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csenha'])) {
        $csenha = $_POST['csenha'];
        $md5csenha = $_POST['md5senha'];
        $sha1csenha = $_POST['sha1senha'];
        $hashcsenha = $_POST['hashsenha'];
    
?>
    <p><b>MD5: </b><?=($md5csenha == md5($csenha)) ? 'são iguais' : 'são diferentes'?></p>
    <p><b>SHA1: </b><?=($sha1csenha == sha1($csenha)) ? 'são iguais' : 'são diferentes'?></p>
    <p><b>PASSWORD_HASH: </b><?=(password_verify($csenha, $hashcsenha)) ? 'são iguais' : 'são diferentes'?></p>
    
<?php } ?>

</body>
</html>