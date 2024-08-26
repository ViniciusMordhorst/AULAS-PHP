<?php
$protegido = true;
require_once('../includes/sessao.inc.php');

$id = NULL;
$nome = NULL;
$numeroComputadores = NULL;
$bloco = NULL;
$sala = NULL;
$liberado = NULL;

$erros = false;


$erroNome = NULL;
$erroNumeroComputadores = NULL;
$erroBloco = NULL;
$erroSala = NULL;
$erroLiberado = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $numeroComputadores = $_POST['numeroComputadores'];
    $bloco = $_POST['bloco'];
    $sala = $_POST['sala'];
    $liberado = $_POST['liberado'];

    require_once('../includes/conexao.inc.php');

    $query = $bancoDados->prepare(
        'SELECT id FROM laboratorio WHERE nome = :nome');
    $query->bindParam(':nome', $nome);
    $query->execute();
    if ($query->rowCount() == 0) {
        if (empty(trim($nome))) {
            $erroNome = 'O nome do laboratório não pode estar em branco';
            $erros = true;
        }
        if (empty(trim($numeroComputadores))) {
            $erroNumeroComputadores = 'O número de computadores não pode estar em branco';
            $erros = true;
        }
        if (empty(trim($bloco))) {
            $erroBloco = 'O bloco não pode estar em branco';
            $erros = true;
        }
        if (empty(trim($sala))) {
            $erroSala = 'A sala não pode estar em branco';
            $erros = true;
        }
        if (empty(trim($liberado))) {
            $erroLiberado = 'O status de liberação não pode estar em branco';
            $erros = true;
        }

        if (!$erros) {
            $query = $bancoDados->prepare(
                "INSERT INTO laboratorio (nome, numero_computadores, bloco, sala, liberado, CRIADO_EM, ATUALIZADO_EM)
                VALUES (:nome, :numeroComputadores, :bloco, :sala, :liberado, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)"
            );
            $query->bindParam(':nome', $nome);
            $query->bindParam(':numeroComputadores', $numeroComputadores);
            $query->bindParam(':bloco', $bloco);
            $query->bindParam(':sala', $sala);
            $query->bindParam(':liberado', $liberado);
            if ($query->execute()) {
                $bancoDados = NULL;
                $_SESSION['mensagem_sucesso'] = "Laboratório cadastrado com sucesso!";
                header('Location: /usuario/home.php');
            }
        }
    } else {
        $erroNome = 'Laboratório já existe';
        $bancoDados = NULL;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Cadastro de Laboratório</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
        <li><a href="../usuario/home.php">Home</a></li>
        <li><a href="../usuario/cadastro.php">Cadastro</a></li>
            <li><a href="../laboratorios/laboratorio.php">Cadastrar Laboratório</a></li>
            <li><a href="../laboratorios/reserva.php">Reservar Laboratório</a></li>
            <li><a href="visualizar_reservas.php">Consultar Reservas</a></li>
            <li><a href="../sair.php">Sair</a></li>
        </ul>
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post">
            <h2>Cadastro de Laboratório</h2>
            <div>
                <label for="nome">Nome do Laboratório</label>
                <input type="text" name="nome" id="nome" value="<?= (!is_null($nome)) ? $nome : ''?>">
                <span><?= (!is_null($erroNome)) ? $erroNome : ''?></span>
            </div>
            <div>
                <label for="numeroComputadores">Número de Computadores</label>
                <input type="number" name="numeroComputadores" id="numeroComputadores" value="<?= (!is_null($numeroComputadores)) ? $numeroComputadores : ''?>">
                <span><?= (!is_null($erroNumeroComputadores)) ? $erroNumeroComputadores : ''?></span>
            </div>
            <div>
                <label for="bloco">Bloco</label>
                <input type="text" name="bloco" id="bloco" value="<?= (!is_null($bloco)) ? $bloco : ''?>">
                <span><?= (!is_null($erroBloco)) ? $erroBloco : ''?></span>
            </div>
            <div>
                <label for="sala">Sala</label>
                <input type="text" name="sala" id="sala" value="<?= (!is_null($sala)) ? $sala : ''?>">
                <span><?= (!is_null($erroSala)) ? $erroSala : ''?></span>
            </div>
            <div>
                <label for="liberado">Liberado</label>
                <select name="liberado" id="liberado">
                    <option value="1" <?= ($liberado == '1') ? 'selected' : '' ?>>Sim</option>
                    <option value="0" <?= ($liberado == '0') ? 'selected' : '' ?>>Não</option>
                </select>
                <span><?= (!is_null($erroLiberado)) ? $erroLiberado : ''?></span>
            </div>
            <div>
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>
