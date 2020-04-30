<?php
session_start();
date_default_timezone_set("America/Bahia");

unset($_SESSION["PEDIDO_FECHADO"]);

if (!$_GET["r"]) {
    header("Location: romaneio.php");
}

$menu = 2;
$subMenu = 2;


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
<div class="container">
    <div class="coluna left div25">
        
        <form class="form" action="../controller/romaneio.conferir.php" method="post" name="formCodigoBarra"
              id="formCodigoBarra">
            <input type="hidden" name="codRomaneio" value="<?php echo $_GET["r"]; ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Leitura do Código de Barras</label>
                <input type="text" class="form-control pula" name="desRomaneio" id="exampleInputCliente"
                       placeholder="Código de Barras" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Conferir</button>

        </form>
		<?php
        if (isset($_SESSION["ERRO_CONFERENCIA"])){
            switch (intval($_SESSION["ERRO_CONFERENCIA"])) {
            case 1 :
                ?>
                <audio id="audioOk">
                    <source src="arq/ok.wav" type="audio/mpeg">
                </audio>
                <script>
                    audio = document.getElementById('audioOk');
                    audio.play();
                    //alert("ERRO! Este pedido já foi conferido.");
                </script>
				<div class="alert alert-success" role="alert">
                    <strong>SUCESSO!</strong> Conferido com sucesso.
                </div>
            <?php
            break;
            case 2 :
            ?>
                <div class="alert alert-warning" role="alert">
                    <strong>ATENÇÃO! </strong> Confira o codigo de barras ou o pedido.
                </div>
            <?php
            break;
            case 3 :
            ?>
                <audio id="audio">
                    <source src="arq/erro.wav" type="audio/mpeg">
                </audio>
                <script>
                    audio = document.getElementById('audio');
                    audio.play();
                    //alert("ERRO! Este pedido já foi conferido.");
                </script>
                <div class="alert alert-danger" role="alert">
                    <strong>ERRO!</strong> Este pedido já foi conferido ou não existe.
					<?php 
					if ($_SESSION["COD_PEDIDO_CONFERIDO"]){
						require_once("../model/romaneio.class.php");			
						$romaneio = new Romaneio();
						// 3001155098					
						$romaneio->selecionar($_SESSION["COD_PEDIDO_CONFERIDO"]);
						?>
						<h5>ROMANEIO</h5>
						<span style="display: block; font-size: 9px; font-weight: bold;">
							<?php echo $romaneio->getDesRomaneio(); ?>
						</span>
					<?php 
					} 
					unset($_SESSION["COD_PEDIDO_CONFERIDO"]);
					?>
                </div>
            <?php
            break;
            case 4:
            ?>
                <div class="alert alert-warning" role="alert">
                    <strong>ATENÇÃO! </strong> Código de Barra Inválido, não inicia com o dígito 2 ou 3.
                </div>
            <?php
            break;
            case 5:
            ?>
                <div class="alert alert-danger" role="alert">
                    <strong>ERRO! </strong> Erro na exclusão dos itens selecionados.
                </div>
                <?php
                break;
            }
            unset($_SESSION["ERRO_CONFERENCIA"]);
        }
        ?>
    </div>
    <div id="divPedidoRomaneioAjax" class="left div70">
        <?php include "pedidos.romaneio.ajax.php"; ?>
    </div>

</div>

</body>
</html>
