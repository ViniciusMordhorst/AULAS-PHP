<?php
    session_start();
    $erro = NULL;

    $usuarios = array(
        'fulano' => password_hash('123456', PASSWORD_DEFAULT),
        'ciclano' => password_hash('1234567890', PASSWORD_DEFAULT)
    );

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        if (array_key_exists($login, $usuarios)) {
            if (password_verify($senha, $usuarios[$login])) {
                $_SESSION['usuario'] = base64_encode($login);
                header('Location: dashboard.php');
            }else {
                $erro = 'login ou senha inválida!';
            }

        }else {
            $erro = 'login ou senha inválida!';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post"> 
        <label for="login"> Login:</label>
        <input type="text" name="login" id="login"><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha"><br><br>
        <button type="submit">Enviar</button>
        <p><?= (!is_null($erro)) ? $erro : '' ?> </p>
    </form>
</body>
</html>