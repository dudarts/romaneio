<?php
session_start();
unset($_SESSION["PEDIDO_FECHADO"]);

$menu = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lojas Jatobá - Romaneio</title>
    <link rel="stylesheet" type="text/css" href="view/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="view/css/css.css">
    <script src="view/js/jquery-2.2.1.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="view/js/bootstrap.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="view/js/ajax.js" type="text/javascript" language="JavaScript"></script>
    <script src="view/js/funcoes.js" type="text/javascript" language="JavaScript"></script>
    <script>
        function etiqueta() {
            //alerta();
            SubmitAjax('post', 'view/etiquetaAjax.php', 'formEtiqueta', 'divInfoCliente');
        }

        function pedidoRepetido() {
            SubmitAjax('post', 'view/pedidoAjax.php', 'formEtiqueta', 'divAlertPedido');
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
                        proximo.select();
                        return false;
                    }
                }
            })
        })
    </script>
</head>
<body onload="document.getElementById('InputPedido').focus();">
<?php include "view/menu.php"; ?>
<div class="container">
    <div class="centro">
        <div class="print-label">
            <form action="controller/pedido.gravar.php" method="post" name="formEtiqueta" id="formEtiqueta">
                <!--<fieldset class="form-group">
                    <label for="exampleInputEmail1">Cód Cliente</label>
                    <input type="text" class="form-control pula" name="cliente" id="exampleInputCliente"
                           placeholder="Digite o código do cliente" onblur="etiqueta();" required>
                                <small class="text-muted">Eduardo Mendes Oliveira.<br>Feira de Santana/Campo Limpo</small>
                </fieldset>-->

                <fieldset class="form-group">
                    <label for="exampleInputEmail1">Nº Pedido</label>
                    <input type="text" class="form-control pula" onblur="etiqueta();pedidoRepetido();" name="pedido"
                           id="InputPedido"
                           placeholder="Digite o número do Pedido" required>
                </fieldset>

                <fieldset class="form-group">
                    <label for="exampleInputEmail1">Nº Caixas</label>
                    <input type="number" class="form-control pula" name="quantidade" id="exampleInputQuantidade" min="1"
                           value="1">
                </fieldset>

                <button type="button" class="btn-lg btn-block btn-primary pula" onclick="javascript:document.getElementById('formEtiqueta').submit();" >Imprimir</button>
            </form>
        </div>

        <div class="print-label" style="width: 10cm">
            <label for="exampleInputEmail1">MODELO</label>
            <div id="divInfoCliente" style="  padding: 3px; width: 8.2cm; height: 4.5cm; margin-bottom: 15px;"></div>
            <div id="divAlertPedido"></div>
        </div>
    </div>
</div>

</body>
</html>
