<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuarioLogado = unserialize(base64_decode($_SESSION['usuario']));

// Verificação para restringir o acesso à `home.php` apenas para administradores
if ($protegido && basename($_SERVER['PHP_SELF']) === 'home.php') {
    if ($usuarioLogado['tipo'] != 1) { // Tipo 1 é Admin
        header('Location: dashboard.php');
        exit();
    }
}
?>
