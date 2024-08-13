<?php
    session_start();

    $_SESSION['nome'] = '';

    session_destroy();

    header('Location: index_sessao.php');
?>