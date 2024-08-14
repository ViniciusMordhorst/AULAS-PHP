<?php 
    $arquivo = isset($_GET['arquivo']) ? $_GET['arquivo'] : NULL;

    $urlDownload = __DIR__ . "/arquivos/" . $arquivo;

    
    if (!is_null($arquivo)) {
        if (file_exists($urlDownload)) {
            header('Content-Description: File Transfer');
            header('Content-Type: aplication/octet-stream');
            header('Content-Disposition: attachment; filename="', $arquivos.'"');
            header('Content-Transfer-Encode: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-lenght: '. filesize($urlDownload));
            ob_clean();
            flush();
            readfile($urlDownload);
            exit();
        }
    } else {
        echo "Arquivo não encontrado.";

    }




?>