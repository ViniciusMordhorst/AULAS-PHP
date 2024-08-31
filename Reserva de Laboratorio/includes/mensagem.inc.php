<?php
//mensagem
if (isset($_SESSION['mensagem_sucesso']) && !empty($_SESSION['mensagem_sucesso'])) {
?>
    <div class="mensagem-sucesso"><?= htmlspecialchars($_SESSION['mensagem_sucesso'], ENT_QUOTES, 'UTF-8') ?></div>
<?php
  
    $_SESSION['mensagem_sucesso'] = '';
}

if (isset($_SESSION['mensagem_erro']) && !empty($_SESSION['mensagem_erro'])) {
?>
    <div class="mensagem-erro"><?= htmlspecialchars($_SESSION['mensagem_erro'], ENT_QUOTES, 'UTF-8') ?></div>
<?php
    
    $_SESSION['mensagem_erro'] = '';
}
?>
