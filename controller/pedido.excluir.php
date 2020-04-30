<?php
@session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/pedido.class.php";
require_once "../model/log.class.php";

unset($_SESSION["PEDIDO_EXCLUIDO"]);
$id = $_POST["id"];
$codPedido = $_POST["codPedido"];

$pedido = new Pedido();

if ($pedido->excluir($id)) {
    $_SESSION["PEDIDO_EXCLUIDO"] = 1;
    new Log($codPedido, "Uma caixa do Pedido Nº $codPedido foi excluído com sucesso!");
} else {
    $_SESSION["PEDIDO_EXCLUIDO"] = 2;
    new Log($codPedido, "ERRO na exclusão de uma caixa do Pedido Nº $codPedido");
}
header("Location: ../view/pedidos.abertos.php");
?>