<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';

$erro = NULL;

function enviarEmail($email, $nomeUsuario, $descricao, $data, $horaInicio, $horaFim) {
    global $erro;

    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // Definido para 2 para fornecer mais informações de depuração
        $mail->CharSet = "UTF-8";
        $mail->Host = "sandbox.smtp.mailtrap.io"; // Corrigido
        $mail->Port = 2525;
        $mail->SMTPAuth = true;
        $mail->Username = "349648680a03b3";
        $mail->Password = "1d2d2c4ba5cb7e";
        $mail->setFrom("noreply@email.com", "Sistema de Reservas");
        $mail->addAddress($email, $nomeUsuario);  
        $mail->Subject = "Confirmação de Reserva";

        // HTML do e-mail
        $htmlView = <<<HTML
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        h1 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmação de Reserva</h1>
        <p>Olá {{nome}},</p>
        <p>Esta é uma confirmação de sua reserva no sistema.</p>
        <p><strong>Descrição:</strong> {{descricao}}</p>
        <p><strong>Data:</strong> {{data}}</p>
        <p><strong>Hora de Início:</strong> {{hora_inicio}}</p>
        <p><strong>Hora de Fim:</strong> {{hora_fim}}</p>
        <p>Obrigado por utilizar o nosso sistema de reservas.</p>
        <p>Atenciosamente,</p>
        <p>Equipe de Suporte</p>
    </div>
</body>
</html>
HTML;

        $htmlView = str_replace("{{nome}}", $nomeUsuario, $htmlView);
        $htmlView = str_replace("{{descricao}}", $descricao, $htmlView);
        $htmlView = str_replace("{{data}}", $data, $htmlView);
        $htmlView = str_replace("{{hora_inicio}}", $horaInicio, $htmlView);
        $htmlView = str_replace("{{hora_fim}}", $horaFim, $htmlView);

        $mail->msgHTML($htmlView);

        if (!$mail->send()) {
            $erro = "Erro ao enviar e-mail: " . $mail->ErrorInfo;
            return $erro;
        }
    } catch (Exception $e) {
        $erro = "Erro ao enviar e-mail: " . $e->getMessage();
        return $erro;
    }

    return NULL;
}

?>
