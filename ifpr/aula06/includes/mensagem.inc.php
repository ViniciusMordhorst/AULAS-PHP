<?php
    if (isset($_SESSION['mesangem_sucesso']) && !empty($_SESSION['mensagem_sucesso'])) {

       
?>  
    <div class="mensagem-sucesso"><?=$_SESSION['mensagem_sucesso']?></div>
<?php
        $_SESSION['mensagem_sucesso'] = '';
    }

    if (isset($_SESSION['mesangem_erro']) && !empty($_SESSION['mensagem_erro'])) {

       
?>  
    <div class="mensagem-erro"><?=$_SESSION['mensagem_erro']?></div>
<?php
        $_SESSION['mensagem_erro'] = '';
    }

?>