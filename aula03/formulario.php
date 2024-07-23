<?php

    $nome = NULL;
    $email = NULL;
    $erro = NULL;
    $clique = NULL;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "E-mail informado não é válido<br>";
        }
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio de Formulário</title>
</head>
<body>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $nome ?>"><br>

        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" value="<?= $email ?>"><br>

        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd"><br><br>

        <label>Sexo:</label>
        <input type="radio" id="m" name="sexo" value="M">  <!-- <?=($Sexo == "f")? 'checked' : '' ?> -->
        <label for="m">M</label>
        <input type="radio" id="f" name="sexo" value="F"> <!-- <?=($Sexo == "m")? 'checked' : '' ?> -->
        <label for="f">F</label><br><br>

        <label for="cities">Selecione a sua cidade:</label>
        <select name="cities" id="cities">
            <option value="selecionar">selecionar</option>
            <option value="mangueirinha">Mangueirinha</option>
            <option value="Palmas">Palmas</option>
            <option value="Clevelandia">Clevelandia</option>
            <option value="Pato Branco">Pato Branco</option>
        </select><br><br>

        <label for="cities">Linguagem de Programação:</label><br>
        <input type="checkbox" id="PHP" name="PHP" value="">
        <label for="PHP"> PHP</label><br>
        <input type="checkbox" id="C" name="C" value="C">
        <label for="C"> C</label><br>

        <label for="descrição">Escreva sobre você:</label><br>
            
                            <!-- <?=(!is_null($descrição) && !empty($descrição) ? $descrição : '') ?> -->
        <textarea id="descrição" name="descrição" rows="4" cols="50"> 

       
        </textarea>
 
            <?= (!is_null($erro)? $erro : '') ?>
            <button type="submit">Enviar</button>
    </form>
    <br>
    <?php if (!is_null($nome)) { ?>
    <p><b>Nome digitado: </b><?= $nome ?></p>
    <p><b>Nome digitado (trim): </b><?= trim($nome) ?></p>
    <p><b>Nome digitado (htmlspecialchars): </b><?= htmlspecialchars_decode(htmlspecialchars($nome)) ?></p>
    <p><b>Nome digitado (strip_tags): </b><?= strip_tags($nome); ?></p> 
    <?php } ?>

   

    <?php 
    if (trim($nome) == $nome) {
        echo 'são iguais';
    } else{
        echo 'são diferentes';
    }
    ?>

    <p><b>Nome: </b><?= $nome ?></p>
    <p><b>email: </b><?= $email ?></p>
    <p><b>sexo: </b><?= $Sexo ?></p>
    <p><b>Linguagem: </b>
    <?php
        foreach ($linguagens as $linguagens) {
            echo $linguagens. ',';
        }

        </p>
</body>
</html>
