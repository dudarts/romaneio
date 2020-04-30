<?php
ob_start();
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/pedido.class.php";

$codeBar = $_POST["desRomaneio"];
$codRomaneio = $_POST["codRomaneio"];

//echo substr($codeBar, 0, 1);
//echo $codRomaneio;
switch(substr($codeBar, 0, 1)){
    case 2 :
        $volume = intval(substr($codeBar, 1, 2));
        $codPedido = substr($codeBar, 3, strlen($codeBar));
        break;
    case 3 :
        $volume = intval(substr($codeBar, 1, 3));
        $codPedido = substr($codeBar, 4, strlen($codeBar));
        break;
    default:
        $_SESSION["ERRO_CONFERENCIA"] = 4;
        header("Location: ../view/pedidos.conferir.php?r=$codRomaneio");
}

$pedido = new Pedido();
$pedido->selecionar($codPedido, $volume, -1);

//var_dump($pedido);
//exit();

if ($pedido->getCodRomaneio() ==  "" && $pedido->getCodPedido() <> "") {
    $pedido->setCodRomaneio($codRomaneio);
    $pedido->setDatConferencia(date("Y-m-d H:i:s"));

    if ($pedido->atualizar()) {
        $_SESSION["ERRO_CONFERENCIA"] = 1;
    } else {
        $_SESSION["ERRO_CONFERENCIA"] = 2;
    }
} else {
    $_SESSION["ERRO_CONFERENCIA"] = 3;
	$_SESSION["COD_PEDIDO_CONFERIDO"] = $pedido->getCodRomaneio();
}


header("Location: ../view/pedidos.conferir.php?r=$codRomaneio");

?>