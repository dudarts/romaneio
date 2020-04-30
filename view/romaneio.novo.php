<?php
session_start();
unset($_SESSION["PEDIDO_FECHADO"]);

require_once "../model/romaneio.class.php";

$menu = 2;
$subMenu = 1;

$romaneio = new Romaneio();

if ($_GET) {
    $codRomaneio = $_GET["r"];
    $romaneio->selecionar($codRomaneio);
} else {
    $codRomaneio = null;
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
    <script>
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
<body onload="document.getElementById('exampleInputCliente').focus();">
<?php include "menu.php"; ?>
<div class="container div30 text-left">

    <form action="../controller/romaneio.gravar.php" method="post" name="formEtiqueta" id="formEtiqueta">
        <?php
        if (!$_GET) {
            ?>
            <input type="hidden" name="tipo" value="novo">
            <?php
        } else {
            ?>
            <input type="hidden" name="tipo" value="editar">
            <?php
        }
        ?>
        <input type="hidden" name="codRomaneio" value="<?php echo $romaneio->getCodRomaneio(); ?>">
        <fieldset class="form-group">
            <label for="exampleInputEmail1">Nome do Romaneio</label>
            <input type="text" class="form-control pula" name="desRomaneio" id="exampleInputCliente"
                   placeholder="Escreva uma descrição para o Romaneio" required
                   value="<?php echo $romaneio->getDesRomaneio(); ?>">
            <!--            <small class="text-muted">Eduardo Mendes Oliveira.<br>Feira de Santana/Campo Limpo</small>-->
        </fieldset>

        <fieldset class="form-group">
            <label for="exampleInputEmail1">Observações</label>
            <textarea rows="5" class="form-control pula" name="obs"
                      id="obs"><?php echo $romaneio->getObs(); ?></textarea>
        </fieldset>
        <button type="submit" class="btn btn-primary pula">Salvar</button>
        <button type="button" class="btn btn-default" onclick="redirecionar('romaneio.php')">Voltar</button>

    </form>
</div>

</body>
</html>
