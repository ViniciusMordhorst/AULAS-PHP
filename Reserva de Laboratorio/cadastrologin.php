<?php
require_once('includes/conexao.inc.php');
$erro = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senhaConfirmacao = $_POST['senha_confirmacao'];

    // Verifique se todos os campos estão preenchidos
    if (!empty($nome) && !empty($email) && !empty($senha) && !empty($senhaConfirmacao)) {
        // Verifique se as senhas coincidem
        if ($senha === $senhaConfirmacao) {
            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Verifique se o e-mail já está cadastrado
            $query = $bancoDados->prepare("SELECT id FROM pessoa WHERE email = :email");
            $query->bindParam(':email', $email);
            $query->execute();

            if ($query->rowCount() == 0) {
                // Inserir novo usuário no banco de dados
                $query = $bancoDados->prepare("INSERT INTO pessoa (nome, email, senha) VALUES (:nome, :email, :senha)");
                $query->bindParam(':nome', $nome);
                $query->bindParam(':email', $email);
                $query->bindParam(':senha', $senhaHash);

                if ($query->execute()) {
                    $_SESSION['mensagem_sucesso'] = "Cadastro realizado com sucesso! Faça login.";
                    header('Location: login.php');
                    exit();
                } else {
                    $erro = "Erro ao realizar o cadastro.";
                }
            } else {
                $erro = "E-mail já cadastrado.";
            }
        } else {
            $erro = "As senhas não coincidem.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="container-center">
        <form action="cadastrologin.php" method="post">
            <h2>Cadastrar</h2>
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" required>
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <div>
                <label for="senha_confirmacao">Confirme a Senha</label>
                <input type="password" name="senha_confirmacao" id="senha_confirmacao" required>
            </div>
            <div>
                <button type="submit">Cadastrar</button>
            </div>
            <span><?= !is_null($erro) ? $erro : '' ?></span>
        </form>
    </div>
</body>
</html>
