<script src="js/funcoes.js" type="text/javascript" language="JavaScript"></script>
<?php
date_default_timezone_set("America/Bahia");

require_once "../model/cliente.class.php";


$codClienteAjax = $_POST["codCliente"];

$clienteAjax = new Cliente();
$clienteAjax->selecionar($codClienteAjax);

if ($clienteAjax->getCodCliente()) {
    ?>

    <button type="button" class="btn btn-warning btn-block"
            onclick="redirecionar('cliente.cadastrar.php?c=<?php echo $codClienteAjax; ?>')">
        <h4>ATENÇÃO! CÓDIGO REPETIDO</h4>
        <b>NOME:</b>
        <small><?php echo $clienteAjax->getNomCliente(); ?></small>
        .
        <b>CIDADE: </b>
        <small><?php echo $clienteAjax->getDesCidade(); ?></small>
        <p>Clique aqui para carregar as informções deste cliente.</p>
    </button>
    <?php

}
?>


