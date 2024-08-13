<?php
    $num1 = 10;
    $num2 = 20;

    /*
    if ($num1 > $num2) {
        echo "Número 1 é maior que numero 2";
    }else if($num1 == $num2){
        echo "Número 1 e numero 2 são iguais";
    }else{
        echo "Número 2 é maior que numero 1";
    }
    */

    echo (
        $num1 > $num2
        ? "numero 1 é maior que numero 2"
        : ($num1 == $num2
            ? "numero 1 e numero 2 são iguais"
            : "numero 2 é maior que numero 1")
        )
?>