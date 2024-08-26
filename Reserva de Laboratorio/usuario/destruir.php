<?php
// Inicie a sessão
session_start();

// Destrua todas as variáveis de sessão
$_SESSION = array();

// Se você deseja que o cookie de sessão também seja destruído, você pode adicionar o seguinte código:
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrua a sessão
session_destroy();

// Redirecione para a página de login ou página inicial
header('Location: login.php');
exit();
?>