<?php
    /*$numeros = array(0 ,1, 2, 3, 4, 5, 6, 7, 8, 9);*/
    $numeros = array('letra1' => 'a', 'letra2' => 'b', 'letra3' =>  'c','letra4' =>  'd', 'letra5' => 'e');

   /* foreach ($numeros as $num) {
        echo $num. "<br>";
    }*/

    foreach ($numeros as $key => $valor) {
        echo $key. "= ". $valor . "<br>";
    }
?>