<?php
    
    
    
    require_once "../model/pdo.class.php";
    
    $conOracle = new DB_ORACLE();
    
    //var_dump($conOracle->query("SELECT * FROM tcli_cliente  WHERE TCLI_CLIENTE_PK = 1032"));
    
    // MOSTRA TODAS AS TABELAS
    /*
    $tabelas = $conOracle->query("SELECT * FROM ALL_TABLES");
    
    foreach ($tabelas as $tabela){
        echo $tabela["TABLE_NAME"] . "<BR>";
    }
    
    EXIT();TPED_HISTORICO_VENDA
     */
    
    $tabelas = $conOracle->query("SELECT * FROM TPED_PEDIDO_VENDA where TPED_NUMERO_PEDIDO_PK = 153570");
    var_dump($tabelas);
    exit();
    /*$cliente = $conOracle->query("SELECT * FROM tcli_cliente  WHERE TCLI_CLIENTE_PK = " . $tabelas[0]["TPED_CLIENTE_FK"]);
    $cep = $conOracle->query("SELECT * FROM TLOC_CIDADE_CEP  where rownum < 2 -- TLOC_CIDADE_CEP_PK =  " . $cliente[0]["TCLI_CIDADE_CEP_FK"]);
   
    echo "Cod: " . $tabelas[0]["TPED_CLIENTE_FK"] . "<br>";            //
    echo "Nome: " . $cliente[0]["TCLI_NOME_RAZAO"] . "<br>";
    echo "Bairro: " . $cliente[0]["TCLI_BAIRRO"] . "<br>";
    echo "Cidade: " . $cep[0]["TLOC_NOME"] . " - " . $cep[0]["TLOC_UF_FK"] . "<br>";
    echo "Referência: " . $cliente[0]["TCLI_PONTO_REFERENCIA"] . "<br><br>";
    var_dump($cliente);
    
 foreach ($tabelas as $tabela){
        foreach($tabela as $k => $v){
            //echo $tabela["TABLE_NAME"] . "<BR>";
            echo "Chave: " . $k . " - Valor: " . $v . "<br>";
        }
    }
    
     */

    
    $stringSQL = "SELECT P.TPED_NUMERO_PEDIDO_PK COD_PEDIDO, ";
    $stringSQL .= "C.TCLI_CLIENTE_PK COD_CLIENTE, ";
    $stringSQL .= "C.TCLI_NOME_RAZAO NOM_CLIENTE, ";
    $stringSQL .= "C.TCLI_BAIRRO DES_BAIRRO, ";
    $stringSQL .= "C.TCLI_PONTO_REFERENCIA DES_PONTO_REFERENCIA, ";
    $stringSQL .= "CI.TLOC_NOME DES_CIDADE, ";
    $stringSQL .= "CI.TLOC_UF_FK COD_ESTADO ";
    $stringSQL .= "FROM TPED_PEDIDO_VENDA P ";
    $stringSQL .= "INNER JOIN TCLI_CLIENTE C ON (C.TCLI_CLIENTE_PK = P.TPED_CLIENTE_FK) ";
    $stringSQL .= "LEFT JOIN TLOC_CIDADE_CEP CI ON (CI.TLOC_CIDADE_CEP_PK = C.TCLI_CIDADE_CEP_FK) ";
    $stringSQL .= "WHERE  P.TPED_NUMERO_PEDIDO_PK = 153419 ";
    
    $cliente = $conOracle->query($stringSQL);
    
    echo "Cod: " . $cliente[0]["COD_PEDIDO"] . "<br>";            //
    echo "Nome: " . $cliente[0]["NOM_CLIENTE"] . "<br>";
    echo "Bairro: " . $cliente[0]["DES_BAIRRO"] . "<br>";
    echo "Cidade: " . $cliente[0]["DES_CIDADE"] . " - " . $cliente[0]["COD_ESTADO"] . "<br>";
    echo "Referência: " . $cliente[0]["DES_PONTO_REFERENCIA"] . "<br><br>";
    var_dump($cliente);
    
    //exit();

    
?>