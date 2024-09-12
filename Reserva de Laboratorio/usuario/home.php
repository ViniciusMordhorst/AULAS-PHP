<?php 
//Página principal do admin
$protegido = true;
require_once('../includes/sessao.inc.php');
require_once("../includes/conexao.inc.php");

$usuarios = array();

//Consulta para obter a lista de usuários
$query = $bancoDados->prepare("SELECT id, nome, email, tipo FROM pessoa ORDER BY nome");
if ($query->execute()) {
    if ($query->rowCount() > 0) {
        $usuarios = $query->fetchAll(PDO::FETCH_OBJ);          
    }
}

$usuarioLogado = array();
if (isset($_SESSION['usuario'])) {
    $usuarioLogado = unserialize(base64_decode($_SESSION['usuario']));
}

function isAdmin($usuario) {
    return isset($usuario['tipo']) && $usuario['tipo'] == 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Lista de Usuários</title>
</head>
<body>
    <div class="container">
        <ul class="menu">
            <li><a href="home.php">Home</a></li>
        
            <?php if (isset($usuarioLogado)) { ?>
                <?php if (isAdmin($usuarioLogado)) { ?>
                    <li><a href="cadastro.php">Cadastro</a></li>
                    <li><a href="../laboratorios/laboratorio.php">Cadastrar Laboratório</a></li>
                <?php } ?>
            <?php } ?>
            <li><a href="../laboratorios/reserva.php">Reservar Laboratório</a></li>
            <li><a href="../laboratorios/visualizar_reservas.php">Consultar Reservas</a></li>
            <li><a href="../sair.php">Sair</a></li>
        </ul>
        <?php include("../includes/mensagem.inc.php") ?>
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Nome</td>
                    <td>E-mail</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody>
                
                <?php if (count($usuarios) > 0) { // Trecho de código que não permite o usuario padrão ver as informações da home, criado inicialmente para evitar que o usuario não veja as informações de outros?> 
                    <?php foreach ($usuarios as $usuario) { ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario->id, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($usuario->nome, ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php if (isset($usuarioLogado) && isAdmin($usuarioLogado)) { ?>
                                    <?= htmlspecialchars($usuario->email, ENT_QUOTES, 'UTF-8') ?>
                                <?php } else { ?>
                                    <i>Somente para admin</i>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (isset($usuarioLogado) && isAdmin($usuarioLogado)) { ?>
                                    <a href="cadastro.php?id=<?= htmlspecialchars($usuario->id, ENT_QUOTES, 'UTF-8') ?>" class="btn-editar" >Editar</a>
                                    <a href="excluir.php?id=<?= htmlspecialchars($usuario->id, ENT_QUOTES, 'UTF-8') ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta usuario?')">Excluir</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">Nenhum usuário localizado.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
