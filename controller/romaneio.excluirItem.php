<?php
ob_start();
session_start();
require_once "../model/pedido.class.php";

$itens = $_POST["ckbPedidoRomaneio"];
$codRomaneio = $_POST["codRomaneio"];

//var_dump($itens);
//exit();

if ($itens and $codRomaneio) {
    $pedido = new Pedido();

    foreach ($itens as $valor) {
        $pedido->selecionar(null , null, $codRomaneio, $valor);
        $pedido->setCodRomaneio(null);

        if (!$pedido->atualizar()) {
            $_SESSION["ERRO_CONFERENCIA"] = 5;
        }
    }
}
header("Location: ../view/pedidos.conferir.php?r=$codRomaneio");
?>

