<?php
//Edita o usuario
$protegido = true;
require_once('../includes/sessao.inc.php');
require_once("../includes/conexao.inc.php");


if (!isset($usuarioLogado) || !isAdmin($usuarioLogado)) {
    header('Location: home.php');
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$usuario = null;
if (!empty($id)) {
    $query = $bancoDados->prepare("SELECT id, nome, email FROM pessoa WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    if ($query->rowCount() > 0) {
        $usuario = $query->fetch(PDO::FETCH_OBJ);
    } else {
        $_SESSION['mensagem_erro'] = "Usuário não encontrado.";
        header('Location: lista.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['salvar'])) {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $erros = false;
    $erroNome = $erroEmail = '';

    if (empty($nome)) {
        $erroNome = 'O nome não pode estar em branco.';
        $erros = true;
    }

    if (empty($email)) {
        $erroEmail = 'O email não pode estar em branco.';
        $erros = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroEmail = 'O email informado não é válido.';
        $erros = true;
    }

    if (!$erros) {
    $tipo = $_POST["tipo"];

        $query = $bancoDados->prepare("UPDATE pessoa SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id");
        $query->bindParam(':nome', $nome, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($query->execute()) {
            $_SESSION['mensagem_sucesso'] = "Usuário atualizado com sucesso!";
            header('Location: lista.php');
            exit();
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao atualizar usuário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Editar Usuário</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
            <li><a href="home.php">Home</a></li>
            <?php if (isset($usuarioLogado) && isAdmin($usuarioLogado)) { ?>
                <li><a href="cadastro.php">Cadastro</a></li>
            <?php } ?>
            
            <?php if (isset($usuarioLogado) && isAdmin($usuarioLogado)) { ?>
                <li><a href="laboratorio.php">Cadastrar Laboratório</a></li>
            <?php } ?>
            <li><a href="../sair.php">Sair</a></li>
        </ul>
        <?php include("../includes/mensagem.inc.php") ?>
        <h1>Editar Usuário</h1>
        <form method="post">
            <div>
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo">
                    <option value="1" <?= $tipo == "1" ? "selected" : "" ?>>Admin</option>
                    <option value="0" <?= $tipo == "0" ? "selected" : "" ?>>Usuário</option>
                </select>
                <span><?= htmlspecialchars($erroTipo ?? "", ENT_QUOTES, "UTF-8") ?></span>
            </div>
            <div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario->nome ?? '') ?>" required>
                <span><?= htmlspecialchars($erroNome ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div>
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo">
                    <option value="1" <?= $tipo == "1" ? "selected" : "" ?>>Admin</option>
                    <option value="0" <?= $tipo == "0" ? "selected" : "" ?>>Usuário</option>
                </select>
                <span><?= htmlspecialchars($erroTipo ?? "", ENT_QUOTES, "UTF-8") ?></span>
            </div>
            <div>
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario->email ?? '') ?>" required>
                <span><?= htmlspecialchars($erroEmail ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <button type="submit" name="salvar">Salvar</button>
        </form>
    </div>
</body>
</html>
