<?php
session_start();
date_default_timezone_set("America/Bahia");

require_once "../model/cliente.class.php";

$codCliente = $_POST["codCliente"];
$cliente = new Cliente();

$cliente->selecionarProton($codCliente);

echo "<b>Nome: </b>" . $cliente->getNomCliente() . "<br>";
echo "<b>Cidade: </b>" . $cliente->getDesCidade() . ". <b>Bairro: </b>" . $cliente->getDesBairro();
?>