<?php 
    $bancoDados = NULL;

    try {
        $bancoDados = new PDO("mysql:host=127.0.0.1;port=33306;dbname=ifpr","root","");

    } catch (\Throwable $th) {
        exit("Erro na conexão com o banco de dados.");
    }