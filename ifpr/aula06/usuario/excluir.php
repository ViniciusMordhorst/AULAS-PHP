<?php

$protegido = true;
require_once('../includes/sessao.inc.php');
require_once("../includes/conexao.inc.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $bancoDados->prepare("DELETE FROM usuario WHERE id = :id");
    $query->bindParam(":id", $id);
    $query->execute();

    if ($query->rowCount() > 0) {
        $bancoDados = NULL;
        $_SESSION["mensagem_sucesso"] = "Usuário excluído com sucesso!";
        header("Location: home.php");

    } else {
        $_SESSION["mensagem_erro"] = "Erro ao excluir usuário selecionado";
        header("Location: home.php");
    }
} else {
    echo "Erro: ID do usuário não encontrado.";
}

?>