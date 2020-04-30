<?php
date_default_timezone_set("America/Bahia");

require_once "../model/cliente.class.php";

if ($_GET) {
$codCliente = $_GET["c"];

$cliente = new Cliente();
$cliente->selecionarProton(@$codCliente);

} else {
  echo "Erro na impressão. Feche esta página, volte ao sistema e tente novamente.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lojas Jatobá - Romaneio</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/css.css">
    <script src="js/jquery-2.2.1.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/funcoes.js" type="text/javascript" language="JavaScript"></script>
    <style>


        #divLinha {
            display: table;
            width: 100%;
        }

    </style>
</head>
<body style="background: white;" onload="document.getElementById('idBtnVoltar').focus();print();">

<input class="btnVoltar noPrint" id="idBtnVoltar" type="button" onclick="redirecionar('cliente.avulso.php');" value="Voltar">


<div class="etiqueta" style="margin: auto;margin-top: 20px;">
    <h5><?php echo $cliente->getCodCliente(); ?> - <?php echo substr($cliente->getNomCliente(), 0, 24); ?></h5>
    <h3><?php echo substr(strtoupper($cliente->getDesCidade()), 0, 16); ?></h3>
    <h4><?php echo $cliente->getDesBairro(); ?></h4>

    <div id="divLinha">

        <div id="divAvisoLacre"> <img src="img/logo.png" alt="LOjas Jatoba" style="width: 50%; padding: 3%"></div>
    </div>
</div>


</body>
</html>

