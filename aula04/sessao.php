<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['nome'] = $_POST['nome'];
        header("Location: index_sessao.php");
    }
?>