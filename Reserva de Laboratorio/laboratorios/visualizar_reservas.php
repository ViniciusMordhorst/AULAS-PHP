<?php
//Lista as reservas
require_once('../includes/conexao.inc.php');
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = unserialize(base64_decode($_SESSION['usuario']));
$usuario_id = $usuario['id'];
$usuario_tipo = $usuario['tipo'];


$query = $bancoDados->query("SELECT id, nome FROM laboratorio");
$laboratorios = $query->fetchAll(PDO::FETCH_ASSOC);

$reservas = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laboratorio'])) {
    $laboratorio_id = $_POST['laboratorio'];

    // Reservas para o laboratório selecionado
    $queryReservas = $bancoDados->prepare("SELECT r.id, r.DESCRICAO, r.DATA, r.HORA_INICIO, r.HORA_FIM, p.id AS usuario_id, p.nome AS usuario_nome 
                                           FROM reserva r 
                                           JOIN pessoa p ON r.PESSOA_ID = p.id 
                                           WHERE r.LABORATORIO_ID = :laboratorio_id 
                                           ORDER BY r.DATA, r.HORA_INICIO");
    $queryReservas->bindParam(':laboratorio_id', $laboratorio_id, PDO::PARAM_INT);
    $queryReservas->execute();
    $reservas = $queryReservas->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Visualizar Reservas</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
            <?php if ($usuario_tipo == 0) { // Página para usuarios comuns ?>
                <li><a href="../dashboard.php">Home</a></li>
            <?php } ?>
        
            <?php if ($usuario_tipo == 1) { ?>
                <li><a href="../usuario/home.php">Home</a></li>
                <li><a href="../usuario/cadastro.php">Cadastro</a></li>
                <li><a href="../laboratorios/laboratorio.php">Cadastrar Laboratório</a></li>
            <?php } ?>
            <li><a href="reserva.php">Reservar Laboratórios</a></li>
            <li><a href="visualizar_reservas.php">Consultar Reservas</a></li>
            <li><a href="../sair.php">Sair</a></li>
        </ul>

        <form action="visualizar_reservas.php" method="post">
            <h2>Visualizar Reservas por Laboratório</h2>

            <div>
                <label for="laboratorio">Laboratório</label>
                <select name="laboratorio" id="laboratorio" required>
                    <option value="">Selecione um laboratório</option>
                    <?php foreach ($laboratorios as $laboratorio) { ?>
                        <option value="<?= htmlspecialchars($laboratorio['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($laboratorio['nome'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div>
                <button type="submit" class="btn-salvar">Visualizar</button>
            </div>
        </form>

        <?php if (!empty($reservas)) { ?>
            <h3 class="mensagem-sucesso">Reservas para o Laboratório Selecionado:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Data</th>
                        <th>Hora Início</th>
                        <th>Hora Fim</th>
                        <th>Usuário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva) { ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva['DESCRICAO'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($reserva['DATA'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($reserva['HORA_INICIO'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($reserva['HORA_FIM'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($reserva['usuario_nome'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php if ($usuario_tipo == 1 || $usuario_id == $reserva['usuario_id']) { ?>
                                            <form method="post" action="gerenciarreserva.php">
                                                <input type="hidden" name="reserva_id" value="<?= $reserva['id'] ?>">
                                                    <button type="submit">Gerenciar </button>
                                            </form>
                                <?php } ?>
                            </td>


                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <p></p>
            <p class="mensagem-erro">Não há reservas para o laboratório selecionado.</p>
        <?php } ?>
    </div>
</body>
</html>
