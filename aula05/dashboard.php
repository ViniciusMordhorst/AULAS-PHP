<?php
    require_once('verificar_login.inc.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <button><a href="logout.php">Sair:</a><br></button>
    <p>Bem Vindo <?= base64_decode($_SESSION['usuario']) ?></p>
    
</body>
</html>