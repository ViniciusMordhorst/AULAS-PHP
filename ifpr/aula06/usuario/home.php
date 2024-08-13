<?php 
    $protegido = true;
    require_once('../includes/sessao.inc.php');
    require_once("../includes/conexao.inc.php");
 


    $usuarios = array();

    $query = $bancoDados->prepare("SELECT id, nome, email FROM usuario ORDER BY nome");
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
        if (isset($usuario) && isset($usuario['tipo_usuario']) && $usuario['tipo_usuario'] == 'admin') {
            return true;
        }
        return false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Lista de usuários</title>
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
        <?php include("../includes/mensagem.inc.php"); ?>
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Nome</td>
                    <td>E-mail</td>
                    <td></td>
                </tr>
            </thead>
            <?php 
            if (count($usuarios) > 0) {
            ?>
            <tbody>
                <?php
                foreach ($usuarios as $usuario) { 
                ?>
                <tr>
                    <td><?= $usuario->id ?></td>
                    <td><?= $usuario->nome ?></td>
                    <td>
                        <?php if (isset($usuarioLogado) && isAdmin($usuarioLogado)) { ?>
                            <?= $usuario->email ?>
                        <?php } else { ?>
                            <i>Somente para admin</i>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if (isset($usuarioLogado) && isAdmin($usuarioLogado)) { include("../includes/mensagem.inc.php");?>
                            <a href="cadastro.php?id=<?= $usuario->id ?>" class="btn-editar">Editar</a>
                            <a href="excluir.php?id=<?= $usuario->id ?>" class="btn-excluir">Excluir</a>
                            
                        <?php } ?>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
            <?php 
            } else {
            ?>
            <tbody>
                <tr>
                    <td colspan="4">Nenhum usuário localizado.</td>
                </tr>
            </tbody>
            <?php
            }
            ?>
        </table>
    </div>
</body>
</html>
