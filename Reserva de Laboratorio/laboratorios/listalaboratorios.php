<?php
// Conexão com o banco de dados
require_once('../includes/conexao.inc.php');

// Verificando a conexão
if (!$bancoDados) {
    die("Falha na conexão com o banco de dados.");
}

// Consulta para buscar informações dos laboratórios
$query = $bancoDados->prepare("SELECT id, nome, numero_computadores, bloco, sala, liberado FROM laboratorio");
$query->execute();

// Obtendo os resultados
$laboratorios = $query->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <title>Lista de Laboratórios</title>
</head>
<body>
    <div class="container">
        <h2>Lista de Laboratórios</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
               
                    <th>Nome</th>
                    <th>Número de Computadores</th>
                    <th>Bloco</th>
                    <th>Sala</th>
                    <th>Liberado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($laboratorios) > 0): ?>
                    <?php foreach ($laboratorios as $laboratorio): ?>
                        <tr>
                     
                            <td><?= htmlspecialchars($laboratorio->nome) ?></td>
                            <td><?= htmlspecialchars($laboratorio->numero_computadores) ?></td>
                            <td><?= htmlspecialchars($laboratorio->bloco) ?></td>
                            <td><?= htmlspecialchars($laboratorio->sala) ?></td>
                            <td><?= $laboratorio->liberado ? 'Sim' : 'Não' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum laboratório encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
