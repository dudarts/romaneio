<?php
ob_start();
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/romaneio.class.php";

if ($_POST) {
    $romaneio = new Romaneio();
	
	if ($romaneio->excluir($_POST["codRomaneio"])) {
		unset($_SESSION["ERRO_SALVAR_ROMANEIO"]);  
	} else {
		$_SESSION["ERRO_SALVAR_ROMANEIO"] = 4;  
    }
} else {
	$_SESSION["ERRO_SALVAR_ROMANEIO"] = 4;  
}
 
    header("Location: ../view/romaneio.php");
?>