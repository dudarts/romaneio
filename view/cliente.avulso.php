<?php
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/cliente.class.php";

$menu = 3;
$subMenu = 4;

@$codCliente = $_GET["c"];

$cliente = new Cliente();
$cliente->selecionar($codCliente);



//echo "romaneio.php";
?><!DOCTYPE html>
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
<body onload="document.getElementById('idCodCliente').focus();">
<?php include "menu.php"; ?>
<div class="container text-left div50">

    <?php
    if (isset($_SESSION["ERRO_SALVA_CLIENTE"])){
    ?>
        <div class="alert alert-danger">
            <strong>ERRO!</strong><?php echo $_SESSION["ERRO_SALVA_CLIENTE"]; ?>
        </div>
    <?php
    }
    ?>
    <form action="../view/etiqueta.avulso.php" method="get" name="formCliente" id="formCliente">       
        <div id="divInfoCliente"></div>
	<div class="div100">
        <fieldset class="form col-lg-4">
            <label for="exampleInputEmail1">Código</label>
            <input type="text" class="form-control " name="c" placeholder="Código do Cliente" required id="idCodCliente">
			<br>
			<button type="submit" class="btn btn-primary">Imprimir etiqueta</button>
		</fieldset>
		
		
	</div>
	
    </form>
</div>
</body>
</html>

<!--<script type="text/javascript">
    $('#idDataTable')
        .removeClass('display')
        .addClass('table table-striped table-bordered');
</script>
-->
