<?php
require_once('../includes/conexao.inc.php');
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = unserialize(base64_decode($_SESSION['usuario']));
$usuario_id = $usuario['id'];
$usuario_tipo = $usuario['tipo'];

// Verifique se o ID da reserva foi passado
if (!isset($_GET['reserva_id']) && !isset($_POST['reserva_id'])) {
    header('Location: visualizar_reservas.php');
    exit();
}

$reserva_id = isset($_GET['reserva_id']) ? $_GET['reserva_id'] : $_POST['reserva_id'];

// Obtenha os detalhes da reserva
$queryReserva = $bancoDados->prepare("SELECT r.id, r.DESCRICAO, r.DATA, r.HORA_INICIO, r.HORA_FIM, p.id AS usuario_id, p.nome AS usuario_nome
                                       FROM reserva r 
                                       JOIN pessoa p ON r.PESSOA_ID = p.id
                                       WHERE r.id = :reserva_id");
$queryReserva->bindParam(':reserva_id', $reserva_id, PDO::PARAM_INT);
$queryReserva->execute();
$reserva = $queryReserva->fetch(PDO::FETCH_ASSOC);

// Verifique se a reserva foi encontrada
if (!$reserva) {
    echo "Reserva não encontrada.";
    exit();
}

// Processamento de exclusão
if (isset($_POST['excluir'])) {
    if ($usuario_tipo == 1 || $usuario_id == ($reserva['usuario_id'] ?? null)) {
        $queryExcluir = $bancoDados->prepare("DELETE FROM reserva WHERE id = :reserva_id");
        $queryExcluir->bindParam(':reserva_id', $reserva_id, PDO::PARAM_INT);
        $queryExcluir->execute();
        header('Location: visualizar_reservas.php');
        exit();
    }
}

// Processamento de edição
if (isset($_POST['editar'])) {
    // Atualizar a reserva com os novos dados
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];

    if ($usuario_tipo == 1 || $usuario_id == ($reserva['usuario_id'] ?? null)) {
        $queryEditar = $bancoDados->prepare("UPDATE reserva SET DESCRICAO = :descricao, DATA = :data, HORA_INICIO = :hora_inicio, HORA_FIM = :hora_fim WHERE id = :reserva_id");
        $queryEditar->bindParam(':descricao', $descricao);
        $queryEditar->bindParam(':data', $data);
        $queryEditar->bindParam(':hora_inicio', $hora_inicio);
        $queryEditar->bindParam(':hora_fim', $hora_fim);
        $queryEditar->bindParam(':reserva_id', $reserva_id, PDO::PARAM_INT);
        $queryEditar->execute();
        
        // Recarregar a reserva atualizada
        $queryReserva->execute();
        $reserva = $queryReserva->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Gerenciar Reserva</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
            <?php if ($usuario_tipo == 0) { // Apenas usuários comuns ?>
                <li><a href="../dashboard.php">Home</a></li>
            <?php } ?>
        
            <?php if ($usuario_tipo == 1) { // Apenas admins podem acessar essas páginas ?>
                <li><a href="../usuario/home.php">Home</a></li>
                <li><a href="../usuario/cadastro.php">Cadastro</a></li>
                <li><a href="../laboratorios/laboratorio.php">Cadastrar Laboratório</a></li>
            <?php } ?>
            <li><a href="reserva.php">Reservar Laboratórios</a></li>
            <li><a href="visualizar_reservas.php">Consultar Reservas</a></li>
            <li><a href="../sair.php">Sair</a></li>
        </ul>

        <h2>Gerenciar Reserva</h2>

        <div>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($reserva['DESCRICAO'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Data:</strong> <?= htmlspecialchars($reserva['DATA'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Hora Início:</strong> <?= htmlspecialchars($reserva['HORA_INICIO'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Hora Fim:</strong> <?= htmlspecialchars($reserva['HORA_FIM'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Usuário:</strong> <?= htmlspecialchars($reserva['usuario_nome'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>

        <?php if ($usuario_tipo == 1 || $usuario_id == ($reserva['usuario_id'] ?? null)) { ?>
            <form method="post">
                <input type="hidden" name="reserva_id" value="<?= $reserva_id ?>">
                
                <!-- Formulário de Edição -->
                <div>
                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" value="<?= htmlspecialchars($reserva['DESCRICAO'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div>
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" value="<?= htmlspecialchars($reserva['DATA'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div>
                    <label for="hora_inicio">Hora Início:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" value="<?= htmlspecialchars($reserva['HORA_INICIO'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div>
                    <label for="hora_fim">Hora Fim:</label>
                    <input type="time" id="hora_fim" name="hora_fim" value="<?= htmlspecialchars($reserva['HORA_FIM'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div>
                    <button type="submit" name="editar" class="btn-editar">Salvar Alterações</button>
                    <button type="submit" name="excluir" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta reserva?')">Excluir Reserva</button>
                </div>
            </form>
        <?php } ?>
    </div>
</body>
</html>
