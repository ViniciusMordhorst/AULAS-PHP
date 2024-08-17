<?php
   // require_once("classes/pessoa.php");
   // require_once("classes/funcionario.php");

    //$pessoa = new Pessoa("Fulano", "fulano@gmail.com", "12345678");

    //echo $pessoa->toString();

    spl_autoload_register(function ($classeNome){
        $diretorioBase = __DIR__ . "/classes/";
        $classe = $diretorioBase . $classeNome . "php";
        if (file_exists($classe)) {
                require $classe;
        }


    });

    $pessoa = new Pessoa("Fulano", "fulano@gmail.com", "12345678", "TI", "Paraguaio");
   
    echo $pessoa->getHtml();

?>