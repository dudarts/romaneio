<?php 
//error_reporting (0); 
session_start(); 
date_default_timezone_set("America/Bahia"); 
require_once "../model/pedido.class.php"; 
require_once "../model/cliente.class.php"; 

$menu=2 ; 
$subMenu=3 ; 

$pedido = new Pedido(); 
$cliente = new Cliente();
$pedidos = $pedido->selecionar(null, null, -2);
$clientes = $cliente->selecionarPeloPedido(array_column($pedidos, "COD_PEDIDO"));
//EXIT();
 //echo "romaneio.php"; 
	?>
    <!DOCTYPE html>
    <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <title>
                Lojas Jatobá - Romaneio
            </title>
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="css/css.css">
            <script src="js/jquery-2.2.1.min.js" type="text/javascript" language="JavaScript">
            </script>
            <script src="js/bootstrap.min.js" type="text/javascript" language="JavaScript">
            </script>
            <script src="js/ajax.js" type="text/javascript" language="JavaScript">
            </script>
            <script src="js/funcoes.js" type="text/javascript" language="JavaScript">
            </script>
            <script src="js/jquery.dataTables.min.js" type="text/javascript" language="JavaScript">
            </script>
            <script type="text/javascript">
            $(document).ready(function() {
    $('#idDataTablePedidosAbertos').DataTable({
		"order": [[ 3, "asc" ]],
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                if (column.index() < 5) {
                    var select = $('<select><option value=""></option></select>').appendTo($(column.footer()).empty()).on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());

                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                    column.data().unique().sort().each(function(d, j) {
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
                <div class="container">
                    <?php 
					switch (@$_SESSION["PEDIDO_EXCLUIDO"]) { 
						case 1: ?>
                        <div class="alert alert-success">
                            <strong>
                                Sucesso!
                            </strong>
                            A caixa foi excluída com sucesso!.
                        </div>
                        <?php 
							break; 
						case 2: 
						?>
                            <div class="alert alert-danger">
                                <strong>
                                    Opss!
                                </strong>
                                Erro na exclusão da caixa. Tente novamente!
                            </div>
                            <?php 
							break; 
						} 
						unset($_SESSION["PEDIDO_EXCLUIDO"]); 
						?>
                                <table id="idDataTablePedidosAbertos" class="table-hover compact" style="font-size: 12px;" >
                                    <thead>
                                        <tr>
                                            <th>
                                                Pedido
                                            </th>
                                            <th>
                                                Data
                                            </th>
                                            <th>
                                                Código
                                            </th>
                                            <th>
                                                Nome
                                            </th>
                                            <th>
                                                Cidade
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>
                                                Pedido
                                            </th>
                                            <th>
                                                Data
                                            </th>
                                            <th>
                                                Código
                                            </th>
                                            <th>
                                                Nome
                                            </th>
                                            <th>
                                                Cidade
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
										//echo count($pedidos); 
										// var_dump($pedidos);
										$count = 0;
										$k = 0;
										foreach ($clientes as $c) { 	
											$pedido->selecionar($c["COD_PEDIDO"], 1, -2)
											//if($c["COD_PEDIDO"]){ 
											//$cliente->selecionarPeloPedido($c["COD_PEDIDO"]); 
											?>
                                            <tr class="text-left">
                                                <td class="col-lg-1">
                                                    <?php echo str_pad($c["COD_PEDIDO"], 5, 0, STR_PAD_LEFT); ?>
												</td>
                                                <td data-order="<?php echo str_pad(strtotime($pedido->getDatImpressao()), 10, "0",STR_PAD_LEFT) ; ?>">
                                                    <?php 
													if ($pedido->getDatImpressao()){
														echo date("d/m/Y H:i", strtotime($pedido->getDatImpressao())); 
													}
													?>
                                                </td>
                                                <td>
                                                    <?php echo $c["COD_CLIENTE"]; ?>
                                                </td>
                                                <td class="text-left" style="">
                                                    <?php echo $c["NOM_CLIENTE"]; ?>
                                                </td>
                                                <td>
                                                    <?php echo $c["DES_CIDADE"]; ?>
                                                </td>
                                                <td class="col-lg-1">
                                                    <form style="padding: 0px; margin: 0px;" action="../controller/pedido.excluir.php"
                                                    method="post" onsubmit="return excluirPedido();">
                                                        <input type="hidden" name="id" value='<?php echo $pedido->getId(); ?>'>
                                                        <input type="hidden" name="codPedido" value='<?php echo $c["COD_PEDIDO"]; ?>'>
                                                        <input type="image" class="img-menu" src="img/glyphicons-193-remove-sign.png"
                                                        title="Excluir Pedido">
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php 
											//} 
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