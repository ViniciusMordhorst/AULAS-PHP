<?php
$protegido = true;
require_once('../includes/sessao.inc.php');
require_once('../includes/conexao.inc.php');

$id = NULL;
$nome = NULL;
$email = NULL;
$senha = NULL;
$tipo = NULL;
$editar = false;
$erros = false;
$erroNome = NULL;
$erroEmail = NULL;
$erroSenha = NULL;
$erroTipo = NULL;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $bancoDados->prepare('SELECT nome, email, tipo FROM pessoa WHERE id = :id');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    if ($query->rowCount() > 0) {
        $usuario = $query->fetch(PDO::FETCH_ASSOC);
        $nome = $usuario['nome'];
        $email = $usuario['email'];
        $tipo = $usuario['tipo'];
        $editar = true;
    } else {
        header('Location: home.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    // Validations
    if (empty(trim($nome))) {
        $erroNome = 'O nome não pode estar em branco';
        $erros = true;
    }
    if (empty(trim($email))) {
        $erroEmail = 'O email não pode estar em branco';
        $erros = true;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroEmail = 'O email informado não é válido';
        $erros = true;
    }
    if (empty(trim($senha)) && !$editar) {
        $erroSenha = 'A senha não pode estar em branco';
        $erros = true;
    }

    if (!$erros) {
        require_once('../includes/conexao.inc.php');

        // Check if email already exists
        $query = $bancoDados->prepare('SELECT id FROM pessoa WHERE email = :email AND id != :id');
        $query->bindParam(':email', $email);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        if ($query->rowCount() == 0) {
            if ($editar) {
                $sql = "UPDATE pessoa SET nome = :nome, email = :email, tipo = :tipo";
                if (!empty($senha)) {
                    $sql .= ", senha = :senha";
                }
                $sql .= " WHERE id = :id";
                $query = $bancoDados->prepare($sql);
                $query->bindParam(':id', $id, PDO::PARAM_INT);
                if (!empty($senha)) {
                    $senha = password_hash($senha, PASSWORD_DEFAULT);
                    $query->bindParam(':senha', $senha);
                }
            } else {
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                $query = $bancoDados->prepare("INSERT INTO pessoa (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)");
                $query->bindParam(':senha', $senha);
            }

            $query->bindParam(':nome', $nome);
            $query->bindParam(':email', $email);
            $query->bindParam(':tipo', $tipo);

            if ($query->execute()) {
                $_SESSION['mensagem_sucesso'] = $editar ? "Usuário editado com sucesso!" : "Usuário cadastrado com sucesso!";
                header('Location: home.php');
                exit();
            } else {
                $erroEmail = 'Erro ao salvar usuário.';
            }
        } else {
            $erroEmail = 'Email já está em uso';
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
    <title><?= $editar ? 'Editar Usuário' : 'Cadastrar Novo Usuário' ?></title>
</head>
<body>
    <div class="container">
        <ul class="menu">
        <li><a href="home.php">Home</a></li>
        <li><a href="cadastro.php">Cadastro</a></li>
            <li><a href="../laboratorios/laboratorio.php">Cadastrar Laboratório</a></li>
            <li><a href="../laboratorios/reserva.php">Reservar Laboratório</a></li>
            <li><a href="../laboratorios/visualizar_reservas.php">Consultar Reservas</a></li>
            <li><a href="../sair.php">Sair</a></li>
        </ul>
        <?php include("../includes/mensagem.inc.php") ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . (isset($id) ? '?id=' . $id : '')) ?>" method="post">
            <h2><?= $editar ? 'Editar Usuário' : 'Cadastro de Usuário' ?></h2>
            <div>
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo">
                    <option value="1" <?= $tipo == "1" ? "selected" : "" ?>>Admin</option>
                    <option value="0" <?= $tipo == "0" ? "selected" : "" ?>>Usuário</option>
                </select>
                <span><?= htmlspecialchars($erroTipo ?? "", ENT_QUOTES, "UTF-8") ?></span>
            </div>
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($nome ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <span><?= htmlspecialchars($erroNome ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <span><?= htmlspecialchars($erroEmail ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" <?= !$editar ? 'required' : '' ?>>
                <span><?= htmlspecialchars($erroSenha ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <button type="submit" class="btn-salvar"><?= $editar ? 'Salvar Alterações' : 'Cadastrar' ?></button>
        </form>
    </div>
</body>
</html>
