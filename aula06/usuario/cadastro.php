<?php
    $protegido = true;
    require_once('../includes/sessao.inc.php');

    $id = NULL;
    $nome = NULL;
    $email = NULL;
    $senha = NULL;
    // verificar se existe algum erro
    $erros = false;
    // guardar mensagem de erro
    
    $erroNome =NULL;
    $erroEmail =NULL;
    $erroSenha =NULL;

   

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST ['nome'];
        $email = $_POST ['email'];
        $senha = $_POST ['senha'];

        require_once('../includes/conexao.inc.php');
     
        $query = $bancoDados->prepare(
            'SELECT id FROM usuario WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        if ($query->rowCount() == 0) {
            if (empty(trim($nome))) {
                $erroNome = 'O nome não pode estar em branco';
                $erros = true;
            }
            if (empty(trim($senha))) {
                $erroSenha = 'A senha não pode estar em branco';
                $erros = true;
            }
            if (empty(trim($email))) {
                $erroEmail = 'O email não pode estar em branco';
                $erros = true;
            }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erroEmail = 'O email informado não é valido';
                $erros = true;
            }

            if (!$erros) {
                $senha = password_hash($senha, PASSWORD_DEFAULT);

                $query= $bancoDados->prepare("INSERT INTO usuario (nome, email, senha)
                VALUE(:nome, :email, :senha)");
                            
                $query->bindParam(':nome', $nome);
                $query->bindParam(':email', $email);
                $query->bindParam(':senha', $senha);
                if ($query->execute()) {
                    $bancoDados = NULL;
                    $_SESSION['mensagem_sucesso'] = "Usuario cadastrado com sucesso!";
                    header('Location: home.php');
                }
            }
        }else {
            $erroEmail = 'Email já está em uso';
            $bancoDados = NULL;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="cadastro.php">Cadastro</a></li>
            <li><a href="../sair.php">Sair</a></li>
        </ul>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h2>Cadastro de usuário</h2>
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?=(!is_null($nome)) ? $nome: '' ?>">
                <span><?=(!is_null($erroNome)) ? $erroNome: '' ?></span>
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?=(!is_null($email)) ? $email: '' ?>">
                <span><?=(!is_null($erroEmail)) ? $erroEmail: '' ?></span>
            </div>
            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha">
                <span><?=(!is_null($erroSenha)) ? $erroSenha: '' ?></span>
            </div>
            <button type="submit" class="btn-salvar">Salvar</button>
        </form>
    </div>
</body>
</html>