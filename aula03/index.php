<?php
   
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        echo "ID: ". $id;
    }
    if (isset($_GET['nome'])){
        $nome = $_GET['nome'];
        echo "NOME: ". $nome;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio GET com PHP</title>
</head>
<body>
    <a href="<?=$_SERVER['PHP_SELF'] ?>?id=1&nome=fulano">Clique aqui</a>
</body>
</html>