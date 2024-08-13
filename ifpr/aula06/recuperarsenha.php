<?php 
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'libs/PHPMailer/src/Exception.php';
    require 'libs/PHPMailer/src/PHPMailer.php';
    require 'libs/PHPMailer/src/SMTP.php';
    
    $email = NULL;
    $erro = NULL;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $email = $_POST['email'];

        require_once('includes/conexao.inc.php');

        $query = $bancoDados->prepare("SELECT id, nome, senha FROM usuario WHERE email = :email");  
        $query->bindParam(':email', $email);

        if ($query->execute()) {
            if ($query->rowCount() >0) {
                $usuario = $query->fetch(PDO::FETCH_OBJ);

                $novaSenha = strtoupper(random_bytes(4));
                $senhaTemp = password_hash($novaSenha, PASSWORD_DEFAULT);

                $query = $bancoDados->prepare("UPDATE usuario SET senha = :senha WHERE email = :email");
                $query->bindParam(':email', $email);
                $query->bindParam(':senha', $senhaTemp);

                if ($query->execute()) {
                    
                    $url = 'http//' .$_SERVER['SERVER_NAME'] . '/ifpr/aula06/login.php';

                    $htmlView = file_get_contents('views/recuperarsenha.html');

                    $htmlView = str_replace("{{nome}}", $usuario->nome, $htmlView);
                    $htmlView = str_replace("{{senha}}", $novaSenha, $htmlView);

                    $htmlView = str_replace("{{url}}", $url, $htmlView);

                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->CharSet = "UTF-8";
                    $mail->Host = "sandbox.smtp.mailtrap.io";
                    $mail->Port = 2525;
                    $mail->SMTPAuth = true;
                    $mail->Username = "349648680a03b3";
                    $mail->Password = "1d2d2c4ba5cb7e";
                    $mail->setFrom("noreply@email.com", "Serviço de recuperação de senha");
                    $mail->addAddress($email, $usuario->nome);  
                    $mail->Subject = "Recuperação de senha";
                    $mail->msgHTML($htmlView);

                    $bancoDados = NULL;
                    if ($mail->send()) {
                        $_SESSION['mensagem_sucesso'] = "Um e-mail com a sua nova senha foi enviado com para: $email";
                        header('Location: login.php');

                    } else {
                        $erro = "Erro ao enviar e-mail";
                    }
                    

                }else {

                    $bancoDados = NULL;
                    $erro = "erro";
                }

            } else {
                $bancoDados = NULL;
                $erro = "E-mail não encontrado.";
            }
            

        } else {
                $bancoDados = NULL;
                $erro = "Erro ao executar a query";
            

        }
          
    
    }
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <title>Recuperar Senha</title>
</head>
<body>
    <div class="container-center">
        <form action="<?=  $_SERVER['PHP_SELF'] ?>" method="post">
            <h2>Recuperar Senha</h2>
            <p>Digite seu e-mail para receber uma nova senha.</p>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="">
                <span></span>
            </div>

           
            <div>
                <button type="submit">Enviar</button>
                
            </div> 

            <span><?=(!is_null($erro)) ? $erro : ''?></span>
           
        </form>
    </div>
</body>
</html>