<?php
require_once("../model/barcode.class.php");
require_once "../model/cliente.class.php";

$qtde = $_POST["quantidade"];
$pedido = $_POST["pedido"];
$codCliente = $_POST["cliente"];

$cliente = new Cliente();

if ($cliente->selecionar($codCliente)) {
    $code_number = $cliente->getCodCliente();
    //new barCodeGenrator($code_number, 1, 'img/codebar/barcode_' . $code_number . '.gif');
    new barCodeGenrator($code_number, 1, 'img/codebar/barcode.gif');


//$code_number = $pedido . $cliente;
//new barCodeGenrator($code_number, 1, 'barcode_' . $code_number . '.gif');


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

    <?php
    for ($i = 1; $i <= 1; $i++) {
        ?>
        <div class="etiqueta">
            <h5><?php echo $cliente->getCodCliente(); ?> - <?php echo substr($cliente->getNomCliente(), 0, 24); ?></h5>
            <h3><?php echo substr(strtoupper($cliente->getDesCidade()), 0, 16); ?></h3>
            <h4><?php echo $cliente->getDesBairro() ?></h4>

            <div id="divLinha">
                <div id="divCodeBar">
                    <img src="/romaneio/view/img/codebar/barcode.gif"/>
                </div>

                <div id="divQtdCaixas">
                    <span>Volume</span>
                    <h1><?php echo $i; ?>/<?php echo $qtde; ?></h1>
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
} else {
    echo "Nenhum cliente com o código " . $codCliente;
}
?>
