<?php
ob_start();
session_start();
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
    <script src="js/funcoes.js" type="text/javascript" language="JavaScript"></script>
    <style>


        #divLinha {
            display: table;
            width: 100%;
        }

    </style>
</head>
<body style="background: white;" onload="document.getElementById('idBtnVoltar').focus();">

<input class="btnVoltar noPrint" id="idBtnVoltar" type="button" onclick="redirecionar('/romaneio');" value="Voltar">
<?php
if (isset($_SESSION["PEDIDO_FECHADO"]) <> "") {

    ?>
    <div class="alert alert-warning noPrint"
         style="max-width: 50%; margin: auto; margin-bottom: 10px; text-align: center; padding: 10px">
        <strong>ATENÇÃO!</strong><br><?php echo $_SESSION["PEDIDO_FECHADO"]; ?>
    </div>

<?php
} else {
include "etiqueta9x6.php";
?>
    <script>//print();</script>
    <?php
}
?>

</body>
</html>
