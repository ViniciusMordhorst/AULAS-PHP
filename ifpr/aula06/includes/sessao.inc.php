<?php
    session_start();

    if ($protegido) {
        if(!isset($_SESSION['usuario'])) {
           header('Location: http://localhost/ifpr/aula06/login.php');

        }else {
            if (empty($_SESSION['usuario'])) {
                header('Location: http://localhost/ifpr/aula06/login.php');
                
            }
        }
    }



?>