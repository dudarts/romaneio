<?php
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/romaneio.class.php";

$menu = 2;
$subMenu = 2;

$romaneio = new Romaneio();
$romaneios = $romaneio->selecionar(null, @$_GET["f"], " ORDER BY DAT_ROMANEIO DESC");
//array_multisort($romaneios, SORT_DESC);
//var_dump($romaneios, "");
//echo "Cód: " . $romaneios[0]["COD_ROMANEIO"];
//echo "romaneio.php";
?>
<!DOCTYPE html>
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
    <script src="js/datetime-moment.js" type="text/javascript" language="JavaScript"></script>
	<script src="js/moment.min.js" type="text/javascript" language="JavaScript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
			
            $('#idDataTableRomaneio').DataTable({
                "order": [[ 2, "asc" ]],
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
    </script>
</head>
<body>
<?php include "menu.php"; ?>
<div class="container div90">
    <div class="div100">
        <?php
        switch (intval(@$_SESSION["ERRO_SALVAR_ROMANEIO"])) {
            case 1 :
                ?>
                <div class="alert alert-success" role="alert">
                    <strong>SUCESSO!</strong> Finalizado com Sucesso.
                </div>
                <?php
                break;
            case 2 :
                ?>
                <div class="alert alert-danger" role="alert">
                    <strong>OPS! </strong>Deu algo errado. Por favor, tente novamente.
                </div>
                <?php
                break;
            case 3 :
                ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Vixe! </strong> Senha de reabertura inválida.
                </div>
                <?php
                break;
			case 4 :
                ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Eita! </strong> Deu erro ao tentar excluir. Tente novamente!
                </div>
                <?php
                break;
            default:
                echo @$_SESSION["ERRO_SALVAR_ROMANEIO"];
        }
        unset($_SESSION["ERRO_SALVAR_ROMANEIO"]);
        ?>
    </div>

    <div class="div100">

        <?php
        //s$btnAtivo = ($letraInicial == $letra["LETRA"]) ? "btn-primary" : "";
        ?>
        <button type="button"
                class="btn btn-default btn-sm btn-sm-custom <?php echo $_GET["f"] == "0" ? "btn-primary" : ""; ?>"
                onclick="redirecionar('romaneio.php?f=0')">
            Somente Romaneios Abertos
        </button>

        <button type="button"
                class="btn btn-default btn-sm btn-sm-custom <?php echo $_GET["f"] == 1 ? "btn-primary" : ""; ?>"
                onclick="redirecionar('romaneio.php?f=1')">
            Somente Romaneios Fechados
        </button>
        <button type="button"
                class="btn btn-default btn-sm btn-sm-custom <?php echo isset($_GET["f"]) ? "" : "btn-primary"; ?>"
                onclick="redirecionar('romaneio.php')">
            Mostrar Todos
        </button>
    </div>


    <table class="table table-sm table-hover div100" border="0" id="idDataTableRomaneio">
        <thead class="navbar-inverse" style="color: white;">
        <tr>
            <th class="col-lg-1">Cód</th>
            <th>Descrição</th>
            <th class="col-lg-2">Data</th>
            <!--            <th>Conferido</th>-->
            <th style="width: 180px;"></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Cód</th>
            <th>Descrição</th>
            <th>Data</th>
            <!--            <th>Conferido</th>-->
            <th></th>
        </tr>
        </tfoot>
        <tbody>
        <?php
		$k = 0;
        foreach ($romaneios as $vetor) {

            ?>
            <tr class="<?php echo $vetor["FLG_ENCERRADO"] ? "" : "vermelho"; ?>">
                <th scope="row" class="col-lg-1"><?php echo str_pad($vetor["COD_ROMANEIO"], 5, "0", STR_PAD_LEFT) ; ?></th>
                <td style="text-align: left;"><?php echo $vetor["DES_ROMANEIO"]; ?></td>
                <td data-order="<?php echo str_pad($k++, 7, "0",STR_PAD_LEFT) ; ?>"><?php echo date("d/m/Y", strtotime($vetor["DAT_ROMANEIO"])); ?></td>
                <!--                <td>-->
                <?php //echo $vetor["FLG_ENCERRADO"] == 1 ? '<img src="img/glyphicons-199-ok-circle.png" title="Romaneio Conferido">' : ""; ?><!--</td>-->
                <td nowrap="" class="col-lg-3">
                    <div class="container-fluid">

                        <!--<div class="navbar-header">
                            <a class="navbar-brand" href="#">
                                <img src="img/glyphicons-17-bin.png" title="Excluir">
                            </a>
                        </div>-->
                        <?php
                        if (!$vetor["FLG_ENCERRADO"]) {
                            ?>
                            <div class="navbar-header">
                                <a class="img-menu" href="romaneio.novo.php?r=<?php echo $vetor["COD_ROMANEIO"]; ?>">
                                    <img src="img/glyphicons-151-edit.png" title="Editar Romaneio">
                                </a>
                            </div>
                            <div class="navbar-header">
                                <a class="img-menu" href="pedidos.conferir.php?r=<?php echo $vetor["COD_ROMANEIO"]; ?>">
                                    <img src="img/glyphicons-260-barcode.png" title="Conferir Pedidos">
                                </a>
                            </div>
                            <div class="navbar-header">
                                <a class="img-menu" href="romaneio.manual.php?r=<?php echo $vetor["COD_ROMANEIO"]; ?>">
                                    <img src="img/glyphicons-30-notes-2.png" title="Lançamento Manual">
                                </a>
                            </div>
                            <div class="navbar-header">
                                <form style="margin: 0px;" action="../controller/romaneio.finalizar.php" method="post"
                                      onsubmit="return confirmaEncerrar('<?php echo $vetor["COD_ROMANEIO"]; ?>', '<?php echo $vetor["DES_ROMANEIO"]; ?>')">
                                    <input type="hidden" name="codRomaneio"
                                           value="<?php echo $vetor["COD_ROMANEIO"]; ?>">
                                    <input type="hidden" name="tipo" value="finalizar">

                                    <input class="img-menu" type="image" src="img/glyphicons-201-download.png"
                                           title="Finalizar Romaneio">
                                </form>
                            </div>
							<?php if (Romaneio::quantidadePedidos($vetor["COD_ROMANEIO"]) == 0){ ?>
							<div class="navbar-header">
                                <form style="margin: 0px;" action="../controller/romaneio.excluir.php" method="post"
                                      onsubmit="return confirmaExcluir();">
                                    <input type="hidden" name="codRomaneio"
                                           value="<?php echo $vetor["COD_ROMANEIO"]; ?>">
                                    <input type="hidden" name="tipo" value="excluir">

                                    <input class="img-menu" type="image" src="img/glyphicons-17-bin.png"
                                           title="Excluir Romaneio">
                                </form>
                            </div>
                            <?php
							}
                        } else {
                            ?>
                            <div class="navbar-header">
                                <a class="img-menu"
                                   href="romaneio.imprimir.php?r=<?php echo $vetor["COD_ROMANEIO"]; ?>">
                                    <img src="img/glyphicons-16-print.png" title="Imprimir">
                                </a>
                            </div>
                            <div class="navbar-header">
                                <a class="img-menu"
                                   href="romaneio.reabrir.php?r=<?php echo $vetor["COD_ROMANEIO"]; ?>">
                                    <img src="img/glyphicons-241-rotation-lock.png" title="Reabrir">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
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
