<?php
//Exclui o usuario
$protegido = true;
require_once('../includes/sessao.inc.php');
require_once("../includes/conexao.inc.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $bancoDados->prepare("DELETE FROM pessoa WHERE id = ?");
    $query->bindParam(1, $id);
    $query->execute();

    if ($query->rowCount() > 0) {
        header("Location: home.php");
        exit;
    } else {
        echo "Erro ao excluir usuário.";
    }
} else {
    echo "Erro: ID do usuário não encontrado.";
}

?>