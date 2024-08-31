<?php
//Conexao com o banco
    $bancoDados = NULL;

    try {
        $bancoDados = new PDO(
            'mysql:host=127.0.0.1;port=33306;dbname=ifpr',
            'root',
            '',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) // Configura o PDO para lançar exceções em caso de erro
        );
    } catch (PDOException $e) {
        // Exibe a mensagem de erro detalhada
        exit('Erro na conexão com o banco de dados: ' . $e->getMessage());
    }
?>
