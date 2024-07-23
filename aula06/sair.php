<?php 
    $protegido = true;
    require_once('includes/sessao.inc.php');

    $_SESSION['usuario'] = '';

    session_destroy();
    header('Location: login.php');
    exit();

?>