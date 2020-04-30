<?php
@session_start();
date_default_timezone_set("America/Bahia");

unset($_SESSION["ERRO_SALVA_CLIENTE"]);

require_once "../model/cliente.class.php";

if ($_POST) {
    $codCliente = $_POST["codCliente"];

    $cliente = new Cliente();
    $cliente->selecionar($codCliente);

    $cliente->setCodCliente(strtoupper($_POST["codCliente"]));
    $cliente->setNomCliente(strtoupper($_POST["nomCliente"]));
    $cliente->setDesBairro(strtoupper($_POST["desBairro"]));
    $cliente->setDesCidade(strtoupper($_POST["desCidade"]));

    switch ($_POST["tipo"]) {
        case "novo":
            if (!$cliente->salvar()){
                $_SESSION["ERRO_SALVA_CLIENTE"] = "Erro ao salvar novo cliente.";
            }
            break;
        case "editar":
            if (!$cliente->atualizar()){
                $_SESSION["ERRO_SALVA_CLIENTE"] = "Erro ao editar um cliente existente.";
            }
            break;
        default:
            $_SESSION["ERRO_SALVA_CLIENTE"] = "Ocorreu um erro ao tentar salvar ou editar. Por favor, tente novamente.";
    }
} else {
    $_SESSION["ERRO_SALVA_CLIENTE"] = "Erro no envio do Formulário. Falha no POST.";
}
header("Location: ../view/cliente.php");
?>