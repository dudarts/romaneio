<script src="view/js/funcoes.js" type="text/javascript" language="JavaScript"></script>
<?php
require_once "../model/pedido.class.php";
require_once "../model/romaneio.class.php";

$codPedido = $_POST["pedido"];


if ($codPedido) {
    $pedido = new Pedido();
	

    if ($pedido->selecionar($codPedido, null, -1)) {
		$romaneio = new Romaneio();
        ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>PEDIDO REPETIDO</strong>
            <h4><?php echo $pedido->volumes($codPedido, 0); ?> VOLUME(S)</h4>
            <div><?php echo $pedido->volumes($codPedido, 2); ?> Conferido(s)</div>
            <div><b></b><?php echo $pedido->volumes($codPedido, 1); ?> Sem Romaneio</div>
			<div style="font-size: 12px; margin-top: 15px;">
			<?php
			if ($romaneio->selecionar($pedido->getCodRomaneio())){
				echo $romaneio->getCodRomaneio() . " - " . $romaneio->getDesRomaneio();
			}
			?>
			</div>
        </div>
        <?php
    }
}
?>
