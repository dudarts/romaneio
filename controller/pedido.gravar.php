<?php
@session_start();
date_default_timezone_set("America/Bahia");

//phpinfo();
//exit();

require_once("../model/barcode.class.php");
require_once "../model/cliente.class.php";
require_once "../model/pedido.class.php";
require_once "../model/log.class.php";
require_once "../model/romaneio.class.php";

unset($_SESSION["PEDIDO_FECHADO"]);
$qtde = $_POST["quantidade"];
$codPedido = $_POST["pedido"];
//$codCliente = $_POST["cliente"];

//echo "Qtd: " . $qtde . "<br>";
//echo "Atual:" . $qtdeAtual;
//exit();

$cliente = new Cliente();
    $cliente->selecionarPeloPedido($codPedido);
    $codCliente = $cliente->getCodCliente();
    //echo $codCliente;
$pedido = new Pedido();
$romaneio = new Romaneio();

if ($pedido->estaEmRomaneioAberto($codPedido)) {
    $romaneio->selecionar($pedido->estaEmRomaneioAberto($codPedido));
    $dataRomaneio = date("d/m/Y", strtotime($romaneio->getDatRomaneio()));

    $_SESSION["PEDIDO_FECHADO"] = "Não foi possível atualizar estas etiquetas.<br>";
    $_SESSION["PEDIDO_FECHADO"] .= "Este pedido se encontra no Romaneio: " . $romaneio->getDesRomaneio() . " ";
    $_SESSION["PEDIDO_FECHADO"] .= "gerado em " . $dataRomaneio;
    $_SESSION["PEDIDO_FECHADO"] .= "<h4>REMOVA ESTE PEDIDO DO ROMANEIO PARA ALTERÁ-LO</h4>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lojas Jatobá - Romaneio</title>
    <link rel="stylesheet" type="text/css" href="../view/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../view/css/css.css">
    <script src="../view/js/jquery-2.2.1.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="../view/js/bootstrap.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="../view/js/funcoes.js" type="text/javascript" language="JavaScript"></script>
    <style>


        #divLinha {
            display: table;
            width: 100%;
        }

    </style>
</head>
<body style="background: white;" onload="document.getElementById('idBtnVoltar').focus();">
	<div class="alert alert-warning noPrint"
         style="max-width: 70%; margin: auto; margin: 10px auto; text-align: center; padding: 10px">
        <strong>ATENÇÃO!</strong><br><?php echo $_SESSION["PEDIDO_FECHADO"]; ?>
	<input class="btnVoltar noPrint" id="idBtnVoltar" type="button" onclick="redirecionar('/romaneio');" value="Voltar">

		</div>

</body>
</html>
<?php
    new Log($codPedido, $_SESSION["PEDIDO_FECHADO"]);
	
	
} else {
    /*if ($pedido->temPedidoSemRomaneio($codPedido)) {

        $_SESSION["SEM_ROMANEIO"] = "Procure bem, pois tem caixas sem romaneio ";

        new Log($codPedido, $_SESSION["SEM_ROMANEIO"]);
    } else {*/

        if ($cliente->selecionarPeloPedido($codPedido)) {
            $qtdeAtual = $pedido->volumes($codPedido, null);


            if ($qtde <> $qtdeAtual and $qtdeAtual > 0) {
                new Log($codPedido, "Alterou de " . $qtdeAtual . " para " . $qtde . " volumes");
            }

            for ($i = 1; $i <= $qtde; $i++) {
                if (@$gravouPedido == false) {
                    $pedido = new Pedido();
                    $pedido->selecionar($codPedido, $i, -1);
                    //var_dump($pedido);
					//exit();
					
					$romaneio->selecionar($pedido->getCodRomaneio());

                    $pedido->setDatImpressao(date("Y-m-d H:i:s"));

                    if (!$romaneio->getFlgEncerrado()){
                        $pedido->setCodRomaneio(null);
                        $pedido->setDatConferencia(null);
                    }

                    if ($pedido->getCodPedido() == $codPedido) {
                        new Log($codPedido, "Reimpressão do volume " . $i);
                        $pedido->setQtdReimpressao($pedido->getQtdReimpressao() + 1);
                        $pedido->atualizar();

                    } else {
                        new Log($codPedido, "Inseriu o volume " . $i);

                        $pedido->setCodPedido($codPedido);
                        $pedido->setCodCliente($cliente->getCodCliente());
                        $pedido->setQtdReimpressao(0);
                        $pedido->setNumVolume($i);
                        $pedido->salvar();
                    }
					// rotina de impressa
					strlen($codPedido) % 2 == 0 ? $aux = 3 : $aux = 2;
					$code_number = $aux . str_pad($i, $aux, "0", STR_PAD_LEFT) . $codPedido;
					
					
					
					$handle = printer_open("\\\\192.168.0.24\\Bematech_LB-1000");
					printer_set_option($handle, PRINTER_MODE, "RAW");
					//var_dump($handle);
					//exit();
					$etiqueta = file_get_contents("etiqueta.prn");
					$etiqueta = str_replace(array('{codeBar}', '{codigo}', '{nome}', '{cidade}', '{bairro}', '{volume}', '{qtde}'), array($code_number, $cliente->getCodCliente(), $cliente->getNomCliente(), $cliente->getDesCidade(), $cliente->getDesBairro(), $i, $qtde), $etiqueta);
					printer_write($handle, $etiqueta);
					printer_close($handle);
					
					// fim da rotina de impressao
					
					
                    $i == $qtde ? $gravouPedido = true : $gravouPedido = false;

                }
                //exit();
            }

            if ($qtde < $qtdeAtual) {
                for ($i = ($qtde + 1); $i <= $qtdeAtual; $i++) {
                    new Log($codPedido, "Excluiu o volume " . $i);
                    $pedido->selecionar($codPedido, $i, -2);
                    $pedido->excluir($pedido->getId());
                }
            }
        }
    //}
	?>
	<script language="JavaScript" src="../view/js/funcoes.js"></script>
<script>
//    redirecionar("../view/printEtiqueta.php?p=<?php echo $codPedido; ?>");
    redirecionar("../");
</script>
<?php
	}
?>

