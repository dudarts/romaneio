<script src="js/funcoes.js" type="text/javascript" language="JavaScript"></script>
<?php
require_once "../model/pedido.class.php";
require_once "../model/cliente.class.php";
require_once "../model/romaneio.class.php";

$cliente = new Cliente();
$pedido = new Pedido();
$romaneio = new Romaneio();
$pAux = new Pedido();
if ($_GET) {
    $codRomaneio = $_GET["r"];
} elseif ($_POST) {
    $codRomaneio = $_POST["codRomaneio"];
} else {
    echo "Falta o código do Romaneio.";
    exit();
}

if (!$codRomaneio) {
    echo "Erro Romaneio nº " . $codRomaneio . ". GET: " . $_GET["r"] . " - POST: " . $_POST["codRomaneio"];
    exit();
} else {
    //echo "Erro Romaneio nº " . $codRomaneio . ". GET: " . $_GET["r"] . " - POST: " . $_POST["codRomaneio"];
    $pedidos = $pedido->selecionar(null, null, $codRomaneio);

    //var_dump($pedidos);
    $romaneio->selecionar($codRomaneio);
}


?>
<!--<div class="div35">
        <h3>Romaneio: <?php /*echo $romaneio->getDesRomaneio(); */ ?></h3>

        <div class="divAvisos">

        </div>

        <fieldset class="form-group">
            <label for="exampleTextarea">Observações Gerais</label>
            <textarea class="form-control" id="exampleTextarea" maxlength="200" rows="5"><?php /*echo $romaneio->getObs(); */ ?></textarea>
        </fieldset>

        <input type="button" class="btn btn-success" value="Salvar as Observações" onclick="submit('salvar.php');">

        <input type="button" class="btn btn-primary btn-block" value="Encerrar e Imprimir">
    </div>-->
<div class="div100">
    <form action="../controller/romaneio.excluirItem.php" method="post">
        <input type="hidden" name="codRomaneio" value="<?php echo $codRomaneio; ?>">

        <table class="table table-hover tableSmall">
            <thead class="navbar-inverse" style="color: white;">
            <tr>
                <th></th>
                <th>Pedido</th>
                <th>Volume</th>
                <th>Cód</th>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Bairro</th>
                <th colspan="2">Obs</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //var_dump($pedido);
            /*if (!is_array($pedido)) {
                echo "ok...";
                $pedidos = array("COD_PEDIDO" => $pedido->getCodPedido(),
                    "NUM_VOLUME" => $pedido->getNumVolume(),
                    "COD_CLIENTE" => $pedido->getCodCliente(),
                    "COD_ROMANEIO" => $pedido->getCodRomaneio(),
                    "DAT_CONFERENCIA" => $pedido->getDatConferencia(),
                    "DAT_IMPRESSAO" => $pedido->getDatImpressao(),
                    "QTD_REIMPRESSAO" => $pedido->getQtdReimpressao(),
                );
                $pedidos = array($pedidos);
            } else {
                echo "aqui";
            }*/
            foreach ($pedidos as $vetor) {
                $clientes = $cliente->selecionarPeloPedido($vetor["COD_PEDIDO"]);
                $totalVolumes = $pAux->volumes($vetor["COD_PEDIDO"], true);
                /*echo "<tr>";
                foreach($vetor as $chave => $valor) {
                    echo "<td>" . $valor . "</td>";
                }
                echo "<td></td>";
                echo "</tr>";*/
                ?>
                <tr>

                    <td><input type="checkbox" name="ckbPedidoRomaneio[]"
                               value="<?php echo $vetor["ID"]; ?>"></td>
                    <th><?php echo $vetor["COD_PEDIDO"]; ?></th>
                    <td><?php echo $vetor["NUM_VOLUME"]; ?></td>
                    <td scope="row"><?php echo $vetor["COD_CLIENTE"]; ?></td>
                    <td style="text-align: left;"><?php echo $cliente->getNomCliente(); ?></td>
                    <td><?php echo $cliente->getDesCidade(); ?></td>
                    <td><?php echo $cliente->getDesBairro(); ?></td>
                    <td class="vermelho">
                        <?php echo $pAux->volumes($vetor["COD_PEDIDO"], 1) ? "Faltando " . $pAux->volumes($vetor["COD_PEDIDO"], true) . " caixa(s)" : ""; ?>

                    </td>
                    <td>
                        <div class="navbar-header">
                            <a class="img-menu" href="romaneio.manual.php?r=<?php echo $vetor["COD_ROMANEIO"]; ?>&p=<?php echo $vetor["COD_PEDIDO"]; ?>&v=<?php echo $vetor["NUM_VOLUME"]; ?>">
                                <img src="img/glyphicons-310-comments.png" title="Digitar Observações">
                            </a>
                        </div>
                    </td>

                    <!--<td>
                    <form name="formPedidoRomaneio" method="post">
                        <input type="hidden" name="codRomaneio" value="<?php /*echo $codRomaneio; */ ?>">
                        <input type="hidden" name="codPedido" value="<?php /*echo $vetor["COD_PEDIDO"]; */ ?>">
                        <input type="hidden" name="numVolume" value="<?php /*echo $vetor["NUM_VOLUME"]; */ ?>">
                        <img src="img/glyphicons-17-bin.png" title="Excluir do Romaneio" class="ponteiro"
                             onclick="exluirItemRomaneioAjax(<?php /*echo $vetor["COD_PEDIDO"]; */ ?>, <?php /*echo $vetor["NUM_VOLUME"]; */ ?>, <?php /*echo $codRomaneio; */ ?>);">
                    </form>
                </td>-->
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <input type="submit" class="btn btn-danger" value="Excluir Itens Selecionados">
        <input type="button" class="btn btn-primary" value="Visualizar Romaneio" onclick="redirecionar('romaneio.imprimir.php?r=<?php echo $codRomaneio; ?>')">
        <button type="button" class="btn btn-default" onclick="redirecionar('romaneio.php')">Voltar</button>

    </form>

</div>

<script>
    function exluirItemRomaneioAjax(pedido, volume, romaneio) {
        if (confirm("Tem certeza que deseja excluir este item do Romaneio")) {
            if (confirm("Esta operação não será desfeita")) {
                var url = '../controller/romaneio.excluirItem.php?p=' + pedido + '&v=' + volume + '&r=' + romaneio;
                alert(url);
                SubmitAjax('post', url, '', 'divPedidoRomaneioAjax');
            }
        }
        //atualizaRomaneioAjax();
    }

    function atualizaRomaneioAjax() {
        SubmitAjax('post', 'pedidos.romaneio.ajax.php', 'formCodigoBarra', 'divPedidoRomaneioAjax');
    }

    /**
     *
     * @param valor     colocar o caminho da action incluindo a extensão ".php"
     */

    function submit(valor) {
        alert(valor);
        //document.form.action = valor;
        //document.form.submit();
    }
</script>