<?php
date_default_timezone_set("America/Bahia");

require_once("../model/barcode.class.php");
require_once "../model/cliente.class.php";
require_once "../model/pedido.class.php";

//$qtde = $_GET["q"];
$codPedido = $_GET["p"];
//$codCliente = $_GET["c"];

$cliente = new Cliente();
$pedido = new Pedido();

$pedido->selecionar($codPedido, 1);
$qtde = $pedido->volumes($codPedido);


if ($cliente->selecionarPeloPedido($codPedido)) {

    for ($i = 1; $i <= $qtde; $i++) {
        strlen($codPedido) % 2 == 0 ? $aux = 3 : $aux = 2;
        $code_number = $aux . str_pad($i, $aux, "0", STR_PAD_LEFT) . $codPedido;
        ?>
        <div class="etiqueta9x6">
            <h5><?php echo $cliente->getCodCliente(); ?> - <?php echo substr($cliente->getNomCliente(), 0, 24); ?></h5>
            <h3><?php echo substr(strtoupper($cliente->getDesCidade()), 0, 16); ?></h3>
            <h4><?php echo $cliente->getDesBairro(); ?></h4>
			<!--<div class="divLinha" id="ptoRef">
				<small><?php //echo $cliente->getPtoReferencia(); ?></small>
			</div>-->

            <div class="div60" style="margin-top: 15px;">              
                <div class="divLinha">
					<span><?php echo $code_number; ?></span>
				</div>
				<div id="divCodeBar">
                    <img alt="<?php echo $code_number; ?>" src="../model/barcode.php?codetype=Code25&size=35&text=<?php echo $code_number; ?>&print=false" />
                </div>
				
            </div>

			<div id="divQtdCaixas" class="div40">
				<span id="spanQtdCaixas"><?php echo $i; ?>/<?php echo $qtde; ?></span>
				<div id="divAvisoLacre">
				<img src="img/favicon.ico" alt="Lojas Jatoba"> LOJAS JATOBÁ
				</div>
			</div>
        </div>
        <?php
    }

    //if ($_SESSION["btn"] == "etiqueta.php");

}
?>
