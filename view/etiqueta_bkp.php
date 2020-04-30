<?php
date_default_timezone_set("America/Bahia");

require_once("../model/barcode.class.php");
require_once "../model/cliente.class.php";
require_once "../model/pedido.class.php";

$qtde = $_GET["q"];
$codPedido = $_GET["p"];
$codCliente = $_GET["c"];

$cliente = new Cliente();
$pedido = new Pedido();

if ($cliente->selecionar($codCliente)) {
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

            .codabar {
                display: block;

                font-family: CodabarMedium;

                transform: scale(2, 3); /* W3C */
                -webkit-transform: scale(2, 3); /* Safari and Chrome */
                -moz-transform: scale(2, 3); /* Firefox */
                -ms-transform: scale(2, 3); /* IE 9 */
                -o-transform: scale(2, 3); /* Opera */
            }

        </style>
    </head>
    <body style="background: white;" onload="document.getElementById('idBtnVoltar').focus();">

    <?php
    for ($i = 1; $i <= $qtde; $i++) {
        $code_number = str_pad($i, 3, "0", STR_PAD_LEFT) . $codPedido;
        //new barCodeGenrator($code_number, 1, 'img/codebar/barcode_' . $code_number . '.gif');
        new barCodeGenrator($code_number, 1, 'img/codebar/barcode' . $i . '.gif');
        ?>
        <div class="etiqueta">
            <h5><?php echo $cliente->getCodCliente(); ?> - <?php echo substr($cliente->getNomCliente(), 0, 24); ?></h5>
            <h3><?php echo substr(strtoupper($cliente->getDesCidade()), 0, 16); ?></h3>
            <h4><?php echo $cliente->getDesBairro() ?></h4>

            <div id="divLinha">
                <small><?php echo $code_number; // str_pad($codPedido, 6, "0", STR_PAD_LEFT); ?></small>
                <div id="divCodeBar">
                    <img src="/romaneio/view/img/codebar/barcode<?php echo $i; ?>.gif"/>
                </div>

                <div id="divQtdCaixas">
                    <span id="spanQtdCaixas"><?php echo $i; ?>/<?php echo $qtde; ?></span>
                </div>
            </div>
            <!--            <div id="divAvisoLacre">Lacre de Segurança. Não receber se estiver violado!</div>-->
        </div>
        <?php
    }

    //if ($_SESSION["btn"] == "etiqueta.php");
    ?>

    </body>
    </html>

    <?php
}
?>
