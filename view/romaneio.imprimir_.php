<?php
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/romaneio.class.php";
require_once "../model/cliente.class.php";

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
    $romaneio = new Romaneio();
    $romaneio->selecionar($codRomaneio);
    $pedidos = $romaneio->listaPedidos($codRomaneio, " ORDER BY DES_CIDADE, NOM_CLIENTE ");
}
//var_dump($romaneio);
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
    <script src="js/ajax.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/funcoes.js" type="text/javascript" language="JavaScript"></script>

</head>
<body>
<?php
include "menu.php";
?>
<div class="container <?php echo $romaneio->getFlgEncerrado() ? "" : "noPrint"; ?>">
    <div class="a4">
        <form action="../controller/romaneio.excluirItem.php" method="post">
            <input type="hidden" name="codRomaneio" value="<?php echo $codRomaneio; ?>">
            <div class="div100" style="margin-bottom: 10px;">
                <div class="div20">
                    <img src="img/logo.png" alt="Lojas Jatobá" style="width: 150px;">
                </div>
                <div class="div60 text-left divInfo">
                    <h4>
                        ROMANEIO: <?php echo $romaneio->getDesRomaneio() . " (Nº " . str_pad($romaneio->getCodRomaneio(), 3, 0, STR_PAD_LEFT) . ")"; ?>
                    </h4>

                    <div class="div50">
                        Data do Romeneio: <?php echo date("d/m/Y", strtotime($romaneio->getDatRomaneio())); ?>
                    </div>
                    <div class="div50">
                        Encerrado em: <?php echo date("d/m/Y", strtotime($romaneio->getDatEncerramento())); ?>
                    </div>
                </div>
            </div>

            <div class="div100 text-left" style="margin-bottom: 10px; border: solid 1px #aab7d1; padding: 5px;">
                <b>Observações: </b><br><?php echo $romaneio->getObs(); ?>
            </div>

            <table class=" table table-hover tableSmall">
                <thead class="navbar-inverse" style="color: white;">
                <tr>
                    <th>Pedido</th>
                    <th>Volumes</th>
                    <th>Cód</th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Bairro</th>
                    <th>Observações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $totalVolumes = 0;
                $totalConferidos = 0;
                $totalPedidos = 0;
                foreach ($pedidos as $vetor) {
                    $cliente = new Cliente();
                    $cliente->selecionarPeloPedido($vetor["COD_PEDIDO"]);
                    $totalPedidos++;
                    $totalConferidos += $vetor["TOTAL_CONFERIDO"];
                    $totalVolumes += $vetor["TOTAL_VOLUMES"];


                    ?>
                    <tr>
                        <th><?php echo $vetor["COD_PEDIDO"]; ?></th>
                        <!--<td><?php /*echo $vetor["TOTAL_CONFERIDO"]; */ ?>/<?php /*echo $vetor["TOTAL_VOLUMES"]; */ ?></td>-->
                        <td><?php echo $vetor["TOTAL_CONFERIDO"]; ?></td>
<td scope="row"><?php echo $cliente->getCodCliente(); ?></td>
                        <td style="text-align: left;"><?php echo $cliente->getNomCliente(); ?></td>
<td><?php echo $cliente->getDesCidade(); ?></td>
                        <td><?php echo $cliente->getDesBairro(); ?></td>
                        <td>
                            <div class="vermelho">
                                <?php
                                if ($vetor["TOTAL_CONFERIDO"] < $vetor["TOTAL_VOLUMES"]) {
									?>
                                    FALTA CAIXA!
                                    <?php
                                } elseif ($vetor["TOTAL_CONFERIDO"] > $vetor["TOTAL_VOLUMES"]) {
                                    ?>
                                    NÃO CONFERIDO
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            echo $vetor["OBS_PEDIDO"];
                            ?>
                        </td>
                    </tr>
                    <?php
                }

                ?>
                <tr>
                    <th colspan="7"> TOTAL: <?php echo $totalPedidos; ?> pedidos.
                        Conferidos <?php echo $totalConferidos; ?> de <?php echo $totalVolumes; ?> volumes.
                    </th>
                </tr>
                </tbody>
            </table>
            <div class="noPrint">
                <?php
                if ($romaneio->getFlgEncerrado()) {
                    ?>
                    <input type="button" class="btn btn-primary" value="Imprimir" onclick="javascript:print();">
                    <input type="button" class="btn btn-warning" value="Imprimir por Cidade"
                           onclick="redirecionar('romaneio.imprimir.cidade.php?r=<?php echo $codRomaneio; ?>')">
                    <?php
                } else {
                    ?>
                    <input type="button" class="btn btn-primary" value="Finalizar Romaneio"
                           onclick="return confirmaEncerrarFuncao('<?php echo $romaneio->getCodRomaneio(); ?>', '<?php echo $romaneio->getDesRomaneio(); ?>','fFinaliza');">
                    <?php
                }
                ?>
                <button type="button" class="btn btn-default" onclick="redirecionar('romaneio.php')">Voltar</button>

            </div>
        </form>
        <form style="margin: 0px;" action="../controller/romaneio.finalizar.php" method="post" name="fFinaliza">
            <input type="hidden" name="codRomaneio"
                   value="<?php echo $romaneio->getCodRomaneio(); ?>">
            <input type="hidden" name="tipo" value="finalizar">
        </form>
    </div>
</div>

</body>
</html>