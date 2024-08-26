<?php
require_once('../includes/conexao.inc.php');
require_once('../controllers/ReservaController.php');
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Obtenha os dados do usuário logado
$usuario = unserialize(base64_decode($_SESSION['usuario']));
$usuario_id = $usuario['id'];
$usuario_tipo = $usuario['tipo'];

// Crie uma instância de ReservaController
$reservaController = new ReservaController($bancoDados);

// Obtenha a lista de laboratórios disponíveis
$query = $bancoDados->query("SELECT id, nome FROM laboratorio");
$laboratorios = $query->fetchAll(PDO::FETCH_ASSOC);

// Se o usuário for admin, obtenha a lista de usuários
if ($usuario_tipo == 1) {
    $queryUsuarios = $bancoDados->query("SELECT id, nome FROM pessoa ORDER BY nome");
    $usuarios = $queryUsuarios->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Se o usuário for admin, ele pode escolher o usuário para quem vai fazer a reserva
    $usuario_reserva_id = ($usuario_tipo == 1 && !empty($_POST['usuario'])) ? $_POST['usuario'] : $usuario_id;

    $laboratorio_id = $_POST['laboratorio'];
    $descricao = $_POST['descricao'];
    $data_reserva = $_POST['data_reserva'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];
    $data_criacao = date('Y-m-d H:i:s');

    // Verifique se os campos obrigatórios estão preenchidos
    if (!empty($laboratorio_id) && !empty($data_reserva) && !empty($hora_inicio) && !empty($hora_fim)) {
        // Verifique se já existe uma reserva para o mesmo laboratório, data e horário
        if ($reservaController->verificarDisponibilidade($laboratorio_id, $data_reserva, $hora_inicio, $hora_fim)) {
            // Insira a reserva no banco de dados
            if ($reservaController->criarReserva($usuario_reserva_id, $laboratorio_id, $descricao, $data_reserva, $hora_inicio, $hora_fim)) {
                $_SESSION['mensagem_sucesso'] = "Reserva realizada com sucesso!";
                if ($usuario_tipo == 1) {
                    header('Location: ../usuario/home.php');
                } else {
                    header('Location: dashboard.php');
                }
                exit();
            } else {
                $erro = "Erro ao realizar a reserva.";
            }
        } else {
            $erro = "Horário indisponível. Por favor, escolha outro horário.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Reservar Laboratório</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
        <?php if ($usuario_tipo == 0) { // Apenas usuarios comuns?>
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

        <form action="reserva.php" method="post">
            <h2>Reservar Laboratório</h2>

            <?php if ($usuario_tipo == 1) { // Campo adicional para admins escolherem o usuário ?>
                <div>
                    <label for="usuario">Usuário</label>
                    <select name="usuario" id="usuario" required>
                        <option value="">Selecione um usuário</option>
                        <?php foreach ($usuarios as $usuarioOption) { ?>
                            <option value="<?= htmlspecialchars($usuarioOption['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($usuarioOption['nome'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

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
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" rows="3" placeholder="Descrição da reserva (opcional)"></textarea>
            </div>

            <div>
                <label for="data_reserva">Data</label>
                <input type="date" name="data_reserva" id="data_reserva" required>
            </div>

            <div>
                <label for="hora_inicio">Hora Início</label>
                <input type="time" name="hora_inicio" id="hora_inicio" required>
            </div>

            <div>
                <label for="hora_fim">Hora Fim</label>
                <input type="time" name="hora_fim" id="hora_fim" required>
            </div>

            <div>
                <button type="submit" class="btn-salvar">Reservar</button>
                <?php if (isset($erro)) { ?>
                    <span><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></span>
                <?php } ?>
            </div>
        </form>
    </div>
</body>
</html>
