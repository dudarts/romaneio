<?php
session_start();
unset($_SESSION["PEDIDO_FECHADO"]);

require_once "../model/romaneio.class.php";

$menu = 2;
$subMenu = 2;

if ($_GET) {
    $romaneio = new Romaneio();
    $romaneio->selecionar($_GET["r"]);
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
    <script src="js/ajax.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/funcoes.js" type="text/javascript" language="JavaScript"></script>
</head>
<body onload="document.getElementById('exampleInputCliente').focus();">
<?php include "menu.php"; ?>
<div class="container div30 text-left">

    <form action="../controller/romaneio.finalizar.php" method="post" name="formEtiqueta" id="formEtiqueta"
          onsubmit="return confirmaReabrir('<?php echo $romaneio->getCodRomaneio(); ?>', '<?php echo $romaneio->getDesRomaneio(); ?>')">
        <input type="hidden" name="tipo" value="reabrir">

        <input type="hidden" name="codRomaneio" value="<?php echo $romaneio->getCodRomaneio(); ?>">
        <fieldset class="form-group">
            <label for="exampleInputEmail1">Senha para reabrir o romaneio</label>
            <input type="password" class="form-control pula" name="senha" id="exampleInputCliente"
                   placeholder="Dawney ou Samuel, digite sua senha" required>
            <!--            <small class="text-muted">Eduardo Mendes Oliveira.<br>Feira de Santana/Campo Limpo</small>-->
        </fieldset>


        <button type="submit" class="btn btn-primary pula">Reabrir</button>
        <button type="button" class="btn btn-default" onclick="redirecionar('romaneio.php')">Voltar</button>

    </form>
</div>

</body>
</html>
