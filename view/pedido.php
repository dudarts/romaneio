<?php
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/pedido.class.php";

$menu = 3;
$subMenu = 5;

//$letraInicial = isset($_GET) ? $_GET["f"] : "";

$pedido = new Pedido();
$pedidos = $pedido->selecionar(null, null, 0);



//echo "romaneio.php";
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lojas Jatobá - Romaneio</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="css/css.css">
    <script src="js/jquery-2.2.1.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/ajax.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/funcoes.js" type="text/javascript" language="JavaScript"></script>
    <script src="js/jquery.dataTables.min.js" type="text/javascript" language="JavaScript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#idDataTable').DataTable({
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        if (column.index() < 4) {
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        }
                    });
                }
            });
        });
        /*
         $(document).ready(function() {
         $('#idDataTable').DataTable( {
         "order": [[ 1, "asc" ]]
         } );
         } );
         */
    </script>
</head>
<body>
<?php include "menu.php"; ?>
<div class="container div60">
    <div class="div100">
        <?php
        foreach ($cliente->letrasIniciais() as $letra) {
            $btnAtivo = ($letraInicial == $letra["LETRA"]) ? "btn-primary" : "";
            ?>
            <button type="button" class="btn btn-default btn-sm btn-sm-custom <?php echo $btnAtivo; ?>"
                    onclick="redirecionar('cliente.php?f=<?php echo $letra["LETRA"]; ?>')">
                <?php echo $letra["LETRA"]; ?>
            </button>
            <?php
        }
        ?>
        <button type="button" class="btn btn-default btn-sm btn-sm-custom"
                onclick="redirecionar('cliente.php')">
            Todos
        </button>
    </div>
    <table id="idDataTable" class="table-sm table-hover compact">
        <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Cidade</th>
            <th>Bairro</th>
            <th></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Cidade</th>
            <th>Bairro</th>
            <th></th>
        </tr>
        </tfoot>
        <tbody>
        <?php
        foreach ($clientes as $c) {
            ?>
            <tr class="text-left">
                <td class="col-lg-1"><?php echo str_pad($c["COD_CLIENTE"], 5, 0, STR_PAD_LEFT); ?></td>
                <td class="text-left"><?php echo $c["NOM_CLIENTE"]; ?></td>
                <td><?php echo $c["DES_CIDADE"]; ?></td>
                <td><?php echo $c["DES_BAIRRO"]; ?></td>
                <td class="col-lg-2">
                    <a class="img-menu" href="cliente.cadastrar.php?c=<?php echo $c["COD_CLIENTE"]; ?>">
                        <img src="img/glyphicons-151-edit.png" alt="Editar Cadastro do Cliente">
                    </a>
                    <a class="img-menu" target="_blank" href="etiqueta.avulso.php?c=<?php echo $c["COD_CLIENTE"]; ?>">
                        <img src="img/glyphicons-260-barcode.png" alt="Etiqueta à Vulso">
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>

<!--<script type="text/javascript">
    $('#idDataTable')
        .removeClass('display')
        .addClass('table table-striped table-bordered');
</script>
-->
