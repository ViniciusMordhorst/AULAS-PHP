<?php
require_once('includes/conexao.inc.php');
session_start();

$erro = NULL;
$email = NULL;
$senha = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (!empty($email) && !empty($senha)) {
        $query = $bancoDados->prepare("SELECT id, nome, senha, tipo FROM pessoa WHERE email = :email");
        $query->bindParam(":email", $email);

        if ($query->execute()) {
            if ($query->rowCount() > 0) {
                $row = $query->fetch(PDO::FETCH_OBJ);
                if (password_verify($senha, $row->senha)) {
                    $usuario = array(
                        'id' => $row->id,
                        'nome' => $row->nome,
                        'tipo' => $row->tipo // 'tipo' pode ser 1 para admin ou outro valor para usuário
                    );

                    $_SESSION['usuario'] = base64_encode(serialize($usuario));

                    // Atualize a data e hora do último login usando CURRENT_TIMESTAMP
                    $usuario_id = $row->id;
                    $updateQuery = $bancoDados->prepare("UPDATE pessoa SET ULTIMO_LOGIN = CURRENT_TIMESTAMP WHERE id = :usuario_id");
                    $updateQuery->bindParam(':usuario_id', $usuario_id);
                    $updateQuery->execute();

                    // Redireciona para a página adequada
                    if ($row->tipo == 1) { // Tipo 1 é Admin
                        header('Location: usuario/home.php');
                    } else {
                        header('Location: dashboard.php');
                    }
                    exit();
                } else {
                    $erro = "Login ou senha incorretos!";
                }
            } else {
                $erro = "Login ou senha incorretos!";
            }
        } else {
            $erro = "Erro ao tentar autenticar.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
    $bancoDados = NULL;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <title>Login</title>
</head>
<body>
    <div class="container-center">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <h2>Login</h2>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <span><?= htmlspecialchars($erro ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha">
                <div class="esqueceu-senha"></div>
                <div><a href="recuperarsenha.php">Esqueceu a senha?</a></div>
                <p>Não tem uma conta? <a href="cadastrologin.php">Cadastre-se aqui</a></p>
                <span><?= htmlspecialchars($erro ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div>
                <button type="submit">Enviar</button>
            </div>
            <span><?= htmlspecialchars($erro ?? '', ENT_QUOTES, 'UTF-8') ?></span>
        </form>
    </div>
</body>
</html>
