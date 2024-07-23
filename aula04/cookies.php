<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        
        setcookie('nome', $nome, time() + 60, '/ifpr/aula04', '127.0.0.1', 1, TRUE);

        header("location: index.php");
    }

?>

