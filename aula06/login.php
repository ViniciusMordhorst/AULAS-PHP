<?php


    $protegido = false;
    require_once('includes/sessao.inc.php');

    $erro = NULL;
    $email = NULL;
    $senha = NULL;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
    }

    require_once('includes/conexao.inc.php');

    $query = $bancoDados->prepare("SELECT id, nome, senha, tipo_usuario FROM usuario WHERE email = :email");
$query->bindParam(":email", $email);

if ($query->execute()) {
    if ($query->rowCount() > 0) {
        $row = $query->fetch(PDO::FETCH_OBJ);
        if (password_verify($senha, $row->senha)) {
            $usuario = array(
                'id' => $row->id,
                'nome' => $row->nome,
                'tipo_usuario' => $row->tipo_usuario
            );

            $_SESSION['usuario'] = base64_encode(serialize($usuario));
            $bancoDados = NULL;
            if ($row->tipo_usuario == 'admin') {
                header('Location: dashboard.php');
            } else {
                header('Location: dashboard.php');
            }
        } else {
            $erro = " Login ou senha incorretos!";
            $bancoDados = NULL;
        }
    } else {
        $erro = "Escreva alguma coisa";
        $bancoDados = NULL;
    }
} else {
    $erro = "Erro ao fritar batatas";
    $bancoDados = NULL;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <div class="container-center">
        <form action="<?=  $_SERVER['PHP_SELF'] ?>" method="post">
            <h2>Login</h2>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="">
                <span></span>
            </div>
            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha">
                <span></span>
            </div>
            <div>
                <button type="submit">Enviar</button>
                
            </div>
            <span><?=(!is_null($erro)) ? $erro : ''?></span>
        </form>
    </div>
</body>
</html>