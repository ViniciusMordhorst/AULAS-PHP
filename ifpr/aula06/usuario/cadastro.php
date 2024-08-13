<?php
$protegido = true;
require_once('../includes/sessao.inc.php');

$nome = $email = $senha = null;
$erros = false;
$erroNome = $erroEmail = $erroSenha = null;
$usuario = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = !empty($_POST['id']) ? $_POST['id'] : NULL;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    require_once('../includes/conexao.inc.php');

    if (is_null($id)) {
        $query = $bancoDados->prepare('SELECT id FROM usuario WHERE email = :email');
        $query->bindParam(':email', $email);
    } else {
        $query = $bancoDados->prepare('SELECT id FROM usuario WHERE email = :email AND id != :id');
        $query->bindParam(':email', $email);
        $query->bindParam(':id', $id);
    }

    if (!$bancoDados) {
        $_SESSION['mensagem_erro'] = "Falha na conexão com o banco de dados.";
        header('Location: home.php');
        exit();
    }

    $query->execute();

    if ($query->rowCount() == 0) {
        if (empty(trim($nome))) {
            $erroNome = 'O nome não pode estar em branco';
            $erros = true;
        }
        if (empty(trim($senha)) && is_null($id)) {
            $erroSenha = 'A senha não pode estar em branco';
            $erros = true;
        }
        if (empty(trim($email))) {
            $erroEmail = 'O email não pode estar em branco';
            $erros = true;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erroEmail = 'O email informado não é válido';
            $erros = true;
        }

        if (!$erros) {
            if (is_null($id)) {
                $senha = password_hash($senha, PASSWORD_DEFAULT);

                $query = $bancoDados->prepare("INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)");
                $query->bindParam(':nome', $nome);
                $query->bindParam(':email', $email);
                $query->bindParam(':senha', $senha);
            }  else {
                $sql = "UPDATE usuario set nome = :nome, email = :email ";

                $sql .= !empty(trim($senha)) ? ", senha = :senha " : "";
                
                $sql .= "WHERE id = :id";

                $query = $bancoDados->prepare($sql);
                $query->bindParam(':nome', $nome);
                $query->bindParam(':email', $email);
                if (!empty(trim($senha))) {
                    $senha = password_hash($senha, PASSWORD_DEFAULT);
                    $query->bindParam(':senha', $senha);
                }
                $query->bindParam(':id', $id);
            }

            if ($query->execute()) {
                $bancoDados = null;
                $_SESSION['mensagem_sucesso'] =  is_null($id) ? "Usuário cadastrado com sucesso!" : "Usuário atualizado com sucesso!";
                header('Location: home.php');
                exit();
            }
        }
    } else {
        $erroEmail = 'Email já está em uso';
        $bancoDados = null;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    require_once("../includes/conexao.inc.php");

    if (!$bancoDados) {
        $_SESSION['mensagem_erro'] = "Falha na conexão com o banco de dados.";
    }

    $id = $_GET['id'];
    $query = $bancoDados->prepare("SELECT id, nome, email FROM usuario WHERE id = :id");
    $query->bindParam(':id', $id);

    if ($query->execute() && $query->rowCount() > 0) {
        $usuario = $query->fetch(PDO::FETCH_OBJ);
        $nome = $usuario->nome;
        $email = $usuario->email;
    } else {
        $_SESSION['mensagem_erro'] = "Usuário não localizado!";
        header("Location: home.php");
        exit();
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
            <input type="hidden" name="id" value="<?=(!is_null($id)) ? $id : '' ?>">
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
