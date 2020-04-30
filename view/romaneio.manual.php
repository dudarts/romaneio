<?php
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/romaneio.class.php";
require_once "../model/pedido.class.php";

$menu = 2;
$subMenu = 1;

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

    $pedido = new Pedido();

    if (@$_GET["p"] && $_GET["v"]) {
        $pedido->selecionar($_GET["p"], $_GET["v"], $codRomaneio);
    }

    //$pedidos = $romaneio->listaPedidos($codRomaneio);
}

//echo "romaneio.php";
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
    <script>
        function infocliente() {
            SubmitAjax('post', 'cliente.info.ajax.php', 'formLancamentoManual', 'divInfoCliente');
        }

        $(document).ready(function () {
            /* ao pressionar uma tecla em um campo que seja de class="pula" */
            $('.pula').keypress(function (e) {
                /* * verifica se o evento é Keycode (para IE e outros browsers) * se não for pega o evento Which (Firefox) */
                var tecla = (e.keyCode ? e.keyCode : e.which);
                /* verifica se a tecla pressionada foi o ENTER */
                if (tecla == 13) {
                    /* guarda o seletor do campo que foi pressionado Enter */
                    campo = $('.pula');
                    /* pega o indice do elemento*/
                    indice = campo.index(this);
                    /*soma mais um ao indice e verifica se não é null *se não for é porque existe outro elemento */
                    if (campo[indice + 1] != null) {
                        /* adiciona mais 1 no valor do indice */
                        proximo = campo[indice + 1];
                        /* passa o foco para o proximo elemento */
                        proximo.focus();
                        return false;
                    }
                }
            })
        })
    </script>
</head>
<body onload="document.getElementById('codCliente').focus();<?php echo $pedido->getId() ? 'infocliente();' : ''; ?>">
<?php include "menu.php"; ?>
<div class="container text-left div30">
    <form id="formLancamentoManual" method="post" action="../controller/romaneio.gravar.php">
        <input type="hidden" name="tipo" value="manual">
        <input type="hidden" name="id" value="<?php echo $pedido->getId(); ?>">
        <input type="hidden" name="codRomaneio" value="<?php echo $codRomaneio;?>">

        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 form-control-label">Cliente</label>
            <div class="col-sm-6">
                <input <?php echo ($pedido->getId()) ? "readonly value='" . $pedido->getCodCliente() . "'" : ""; ?> required type="text" name="codCliente" class="form-control pula" id="codCliente" placeholder="Código do Cliente" onblur="infocliente();">
            </div>
        </div>

        <div class="divInfo" id="divInfoCliente" style="padding: 5px;"></div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 form-control-label">Pedido</label>
            <div class="col-sm-6">
                <input <?php echo ($pedido->getId()) ? "readonly value='" . $pedido->getCodPedido() . "'" : ""; ?> type="text" name="codPedido" class="form-control pula" id="codPedido" placeholder="Número do Pedido">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 form-control-label">Volume</label>
            <div class="col-sm-3">
                <input <?php echo ($pedido->getId()) ? "readonly value='" . $pedido->getNumVolume() . "'" : ""; ?> type="number" name="numVolume" class="form-control pula" id="numVolume" min="0" value="0">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 form-control-label">Observações</label>
            <div class="col-sm-10">
                <textarea name="obs" id="obs" class="form-control pula" placeholder="Escreva as observações" maxlength="200" rows="5"><?php echo ($pedido) ?  $pedido->getObs() : ""; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary pula">Salvar</button>
                <button type="button" class="btn btn-default" onclick="redirecionar('romaneio.php')">Voltar</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
