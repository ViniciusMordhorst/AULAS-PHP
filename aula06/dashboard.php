<?php
$protegido = true;
require_once('includes/sessao.inc.php');

$usuario = array();
if (isset($_SESSION['usuario'])) {
    $usuario = unserialize(base64_decode($_SESSION['usuario']));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <title>Lista de usuários</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="usuario/home.php">Usuário</a></li>
            <?php if (isset($usuario['nome'])) {?>
                <p>Bem-Vindo <?= $usuario['nome']?></p>
            <?php }?>
            <li><a href="sair.php">Sair</a></li>
        </ul>
        
    </div>
</body>
</html>