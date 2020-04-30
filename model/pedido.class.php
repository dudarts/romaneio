<?php
require_once "pdo.class.php";

class Pedido
{
    private $id;
    private $codPedido;
    private $codCliente;
    private $codRomaneio;
    private $numVolume;
    private $datImpressao;
    private $datConferencia;
    private $qtdReimpressao;
    private $obs;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCodPedido($pCodPedido)
    {
        $this->codPedido = $pCodPedido;
    }

    public function getCodPedido()
    {
        return $this->codPedido;
    }

    public function setCodCliente($pCodCliente)
    {
        $this->codCliente = $pCodCliente;
    }

    public function getCodCliente()
    {
        return $this->codCliente;
    }

    public function setCodRomaneio($pCodRomaneio)
    {
        $this->codRomaneio = $pCodRomaneio;
    }

    public function getCodRomaneio()
    {
        return $this->codRomaneio;
    }

    public function setNumVolume($pNumVolume)
    {
        $this->numVolume = $pNumVolume;
    }

    public function getNumVolume()
    {
        return $this->numVolume;
    }

    public function setDatImpressao($pDatImpressao)
    {
        $this->datImpressao = $pDatImpressao;
    }

    public function getDatImpressao()
    {
        return $this->datImpressao;
    }

    public function setDatConferencia($pDatConferencia)
    {
        $this->datConferencia = $pDatConferencia;
    }

    public function getDatConferencia()
    {
        return $this->datConferencia;
    }

    public function getQtdReimpressao()
    {
        return $this->qtdReimpressao;
    }

    public function setQtdReimpressao($qtdReimpressao)
    {
        $this->qtdReimpressao = $qtdReimpressao;
    }

    /**
     * @return mixed
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param mixed $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }


    public function selecionar($pCodPedido, $numVolume = null, $codRomaneio = 0, $id = null, $codCliente = null, $extraSQL = null)
    {
        $con = DB::conexao();

        $stringSQL = " SELECT * FROM pedido WHERE 1 = 1 AND IFNULL(COD_PEDIDO, 0) > 0 ";

        if ($id) {
            $stringSQL .= " AND ID = " . $id;
        }

        if ($pCodPedido) {
            $stringSQL .= " AND COD_PEDIDO = " . $pCodPedido;
        }

        if ($numVolume) {
            $stringSQL .= " AND IFNULL(NUM_VOLUME, 0) = " . $numVolume;
        }

        if (isset($codRomaneio)) {
			switch ($codRomaneio){
				case -2:
					$stringSQL .= " AND COD_ROMANEIO IS NULL";
					break;
				case -1 : 
					break;
				case 0 :
					$stringSQL .= " AND COD_ROMANEIO IS NOT NULL ";
					break;
				default:
					$stringSQL .= " AND IFNULL(COD_ROMANEIO, 0) = " . $codRomaneio;
					
			}
			/*
			if ($codRomaneio > -1){
				switch ($cod)
				if ($codRomaneio == 0){
					$stringSQL .= " AND COD_ROMANEIO IS NOT NULL ";
				} else {
					$stringSQL .= " AND IFNULL(COD_ROMANEIO, 0) = " . $codRomaneio;
				}
			}*/
        }

        if ($codCliente) {
            $stringSQL .= " AND COD_CLIENTE = " . $codCliente;
        }

        if ($extraSQL) {
            $stringSQL .= " " . $extraSQL;
        }

        $sql = $con->prepare($stringSQL);

        //echo $stringSQL . "<BR>";

        if ($sql->execute()) {
            $pedido = $sql->fetchAll(PDO::FETCH_ASSOC);
            if ($sql->rowCount() == 1) {
                $obj = $pedido[0];

                $this->setId($obj["ID"]);
                $this->setCodCliente($obj["COD_CLIENTE"]);
                $this->setCodPedido($obj["COD_PEDIDO"]);
                $this->setCodRomaneio($obj["COD_ROMANEIO"]);
                $this->setDatImpressao($obj["DAT_IMPRESSAO"]);
                $this->setDatConferencia($obj["DAT_CONFERENCIA"]);
                $this->setNumVolume($obj["NUM_VOLUME"]);
                $this->setQtdReimpressao($obj["QTD_REIMPRESSAO"]);
                $this->setObs($obj["OBS"]);
                //return $this;
                //return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
            return $pedido;

        } else {
            return false;
        }
    }

    public function salvar()
    {
        $con = DB::conexao();

        if ($this) {
            $stringSQL = 'INSERT INTO pedido (COD_PEDIDO, COD_CLIENTE, NUM_VOLUME, COD_ROMANEIO, DAT_IMPRESSAO, DAT_CONFERENCIA, QTD_REIMPRESSAO, OBS) VALUES (';

            //$stringSQL .= "COD_PEDIDO = ";
            $this->getCodPedido() ? $stringSQL .= $this->getCodPedido() : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getCodCliente() ? $stringSQL .= $this->getCodCliente() : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getNumVolume() ? $stringSQL .= $this->getNumVolume() : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getCodRomaneio() ? $stringSQL .= $this->getCodRomaneio() : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getDatImpressao() ? $stringSQL .= "'" . $this->getDatImpressao() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getDatConferencia() ? $stringSQL .= "'" . $this->getDatConferencia() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getQtdReimpressao() ? $stringSQL .= $this->getQtdReimpressao() : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getObs() ? $stringSQL .= "'" . $this->getObs() . "'" : $stringSQL .= 'null';

            $stringSQL .= ");";


            //echo $stringSQL . "<br>";
            //exit();
            $sql = $con->prepare($stringSQL);
            return $sql->execute();
        } else {
            return false;
        }
    }

    public function atualizar()
    {

        if ($this) {
            $con = DB::conexao();

            $stringSQL = 'UPDATE pedido SET ';

            $stringSQL .= "COD_PEDIDO = ";
            $this->getCodPedido() ? $stringSQL .= $this->getCodPedido() : $stringSQL .= 'null';

            $stringSQL .= ", COD_CLIENTE = ";
            $this->getCodCliente() ? $stringSQL .= $this->getCodCliente() : $stringSQL .= 'null';

            $stringSQL .= ", NUM_VOLUME = ";
            $this->getNumVolume() ? $stringSQL .= $this->getNumVolume() : $stringSQL .= 'null';

            $stringSQL .= ", COD_ROMANEIO = ";
            $this->getCodRomaneio() ? $stringSQL .= $this->getCodRomaneio() : $stringSQL .= 'null';

            $stringSQL .= ", DAT_IMPRESSAO = ";
            $this->getDatImpressao() ? $stringSQL .= "'" . $this->getDatImpressao() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", DAT_CONFERENCIA = ";
            $this->getDatConferencia() ? $stringSQL .= "'" . $this->getDatConferencia() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", QTD_REIMPRESSAO = ";
            $this->getQtdReimpressao() ? $stringSQL .= $this->getQtdReimpressao() : $stringSQL .= 'null';

            $stringSQL .= ", OBS = ";
            $this->getObs() ? $stringSQL .= "'" . $this->getObs() . "'" : $stringSQL .= 'null';

            $stringSQL .= " WHERE ID = " . $this->getId();


            //echo $stringSQL . "<br>";
            //exit();
            $sql = $con->prepare($stringSQL);
            return $sql->execute();
        } else {
            return false;
        }
    }

    public function excluir($id)
    {
        $con = DB::conexao();

        if ($id) {
            $stringSQL = ' delete from pedido where ID = :id';

            $sql = $con->prepare($stringSQL);
            $sql->bindParam(":id", $id);
			
			//echo "id: " . $id;
			//exit();
			
            return $sql->execute();
        } else {
            return false;
        }
    }


    public function volumes($pCodPedido, $pedidoEmRomaneios = false)
    {
        $con = DB::conexao();

        if ($pCodPedido == null) {
            $pCodPedido = 0;
        }

        $stringSQL = " SELECT COUNT(COD_PEDIDO) TOTAL FROM pedido WHERE COD_PEDIDO = :codPedido ";

		/**
		* QUALQUER OUTRO NUMEROS, INDEPENDENTES SE FOI CONFERIO OU NAO
		* 1 - NÃO CONFERIDOS
		* 2 - CONFEIROS
		*/
		switch ($pedidoEmRomaneios){
			case 1:
				$stringSQL .= " AND COD_ROMANEIO IS NULL ";
				break;
			case 2:
				$stringSQL .= " AND COD_ROMANEIO IS NOT NULL ";
				break;
		}
		/*
        if (isset($pedidoEmRomaneios)){
            $aux = $pedidoEmRomaneios ? " not " : "";
            $stringSQL .= " AND COD_ROMANEIO IS  $aux  NULL ";
        }
*/
		//echo $stringSQL;
		
        $sql = $con->prepare($stringSQL);
        $sql->bindParam(":codPedido", $pCodPedido);


        //echo Funcoes::queryStringSQL($stringSQL, ":codOtica", $pCodOtica, ":usuario", $pCodUsuario, ":senha", $pCodSenha);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $obj = $sql->fetchAll(PDO::FETCH_ASSOC);
            $obj = $obj[0];

            return $obj["TOTAL"];
        } else {
            return 0;
        }
    }

    public function estaEmRomaneioAberto($codPedido = null)
    {
        $con = DB::conexao();

        $stringSQL = " SELECT P.COD_ROMANEIO FROM pedido P ";
        $stringSQL .= " INNER JOIN romaneio R ON (R.COD_ROMANEIO = P.COD_ROMANEIO) ";
        $stringSQL .= " WHERE P.COD_PEDIDO = :codPedido AND IFNULL(FLG_ENCERRADO, 0) = 0";

        //echo $stringSQL;
        
        $sql = $con->prepare($stringSQL);

        if ($codPedido) {
            $sql->bindParam(":codPedido", $codPedido);
        } else {
            $sql->bindParam(":codPedido", $this->getCodPedido());
        }

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $obj = $sql->fetchAll(PDO::FETCH_ASSOC);
            $obj = $obj[0];

            return $obj["COD_ROMANEIO"];
        } else {
            return false;
        }
    }

    public function temPedidoSemRomaneio($codPedido = null)
    {
        $con = DB::conexao();

        $stringSQL = " select COUNT(ID) TOTAL from pedido ";
        $stringSQL .= " where COD_PEDIDO = $codPedido AND COD_ROMANEIO IS NULL";

        //echo $stringSQL;

        $sql = $con->prepare($stringSQL);

        if ($codPedido) {
            $sql->bindParam(":codPedido", $codPedido);
        } else {
            $sql->bindParam(":codPedido", $this->getCodPedido());
        }

        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


	public function info($codRomaneio, $codPedido)
    {
        $con = DB::conexao();

        $stringSQL = "SELECT P.COD_PEDIDO, ";
        $stringSQL .= " P.COD_CLIENTE, ";
        $stringSQL .= " R.COD_ROMANEIO, ";
        $stringSQL .= " R.DES_ROMANEIO, ";
        $stringSQL .= " R.DAT_ROMANEIO, ";
        $stringSQL .= " R.FLG_ENCERRADO, ";
        $stringSQL .= " R.DAT_ENCERRAMENTO, ";
        $stringSQL .= " R.OBS, ";
        $stringSQL .= " COUNT(P.NUM_VOLUME) TOTAL_CONFERIDO, ";
        $stringSQL .= " (SELECT COUNT(PP.NUM_VOLUME) FROM pedido PP WHERE (PP.COD_PEDIDO = P.COD_PEDIDO) AND (PP.COD_ROMANEIO IS NULL OR PP.COD_ROMANEIO = P.COD_ROMANEIO)) TOTAL_VOLUMES,  ";
        $stringSQL .= " GROUP_CONCAT(P.OBS SEPARATOR ', ') OBS_PEDIDO  ";
        $stringSQL .= " FROM pedido P ";
        $stringSQL .= " LEFT JOIN romaneio R ON (R.COD_ROMANEIO = P.COD_ROMANEIO) ";
        $stringSQL .= " WHERE P.COD_ROMANEIO = $codRomaneio ";
        $stringSQL .= " AND P.COD_PEDIDO = $codPedido";
        $stringSQL .= " GROUP BY P.COD_PEDIDO, COD_CLIENTE ";

        
        $sql = $con->prepare($stringSQL);
        $sql->bindParam(":codRomaneio", $codRomaneio);
        $sql->bindParam(":codPedido", $codPedido);

//        echo $stringSQL;

        if ($sql->execute()) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
