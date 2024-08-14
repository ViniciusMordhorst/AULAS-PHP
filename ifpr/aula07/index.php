<?php
    require_once("includes/conexao.inc.php");

    $msg = NULL;
    $nome = NULL;
    $arquivos = array();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {// METODO POST 
        $pasta = __DIR__ . "/arquivos/";
        $arquivo = $_FILES['arquivo']['name'];
        $arquivoUpload = $pasta . $arquivo;

        if (is_writable($pasta)) {
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivoUpload)){ //upload sucesso
                $query = $bancoDados->prepare("INSERT INTO arquivos (nome) VALUES (:nome)");
                $query->bindParam(':nome', $arquivo);

                if ($query->execute()) {
                    $bancoDados = NULL;
                    $msg = 'Arquivo enviado com sucesso!';
                } else {
                $msg = 'Erro ao atualizar o Banco de Dados.';

                }
                
                
             
            } else {
                $msg = 'Erro ao fazer o upload do arquivo';
        
            } 
    

        } else {
            $msg = 'Erro de permissão na pasta de destino';
        }

    } else {// METODO GET

        $query = $bancoDados->prepare("SELECT nome FROM arquivos ORDER BY nome");
        if ($query->execute()) {
            if ($query->rowCount() > 0) {
             $arquivos = $query->fetchAll(PDO::FETCH_OBJ);

            }

        }
        
    }
    
   
    


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Arquivos</title>
</head>
<body>
        <main> 
            <h1>Upload de arquivos</h1>
            <form action="<?= $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <section>
                    <label for="arquivo">Arquivo</label>
                    <input type="file" name="arquivo" id="arquivo">
                </section>

                <section>
                    <button type="submit">Enviar</button>
                </section>
               
                <section id="msg">
                    <?= !is_null($msg) ? $msg : ''?>
                </section>
                </form>
                <?php 
                    if (count($arquivos) > 0) {
                    
                ?>
                    <h2>Arquivos</h2>
                        <section>
                        <ul>
                <?php
                        foreach ($arquivos as $arquivo) {
                ?>
                        <li>
                            <a href="download.php?arquivo=<?=$arquivo->nome?>">
                            <?=$arquivo->nome ?>
                            </a>


                        </li>
                <?php
                    }
                ?>
                        </ul>
                        </section>
                <?php
                    }
                ?>
        </main>


</body>
</html>