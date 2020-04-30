<?php
require_once "pdo.class.php";

class Romaneio
{
    private $codRomaneio;
    private $desRomaneio;
    private $datRomaneio;
    private $flgEncerrado;
    private $datEncerramento;
    private $obs;

    public function setCodRomaneio($pCodRomaneio)
    {
        $this->codRomaneio = $pCodRomaneio;
    }

    public function getCodRomaneio()
    {
        return $this->codRomaneio;
    }

    public function setDesRomaneio($pDesRomaneio)
    {
        $this->desRomaneio = $pDesRomaneio;
    }

    public function getDesRomaneio()
    {
        return $this->desRomaneio;
    }

    /**
     * @return mixed
     */
    public function getDatRomaneio()
    {
        return $this->datRomaneio;
    }

    /**
     * @param mixed $datRomaneio
     */
    public function setDatRomaneio($datRomaneio)
    {
        $this->datRomaneio = $datRomaneio;
    }

    /**
     * @return mixed
     */
    public function getFlgEncerrado()
    {
        return $this->flgEncerrado;
    }

    /**
     * @param mixed $flgEncerrado
     */
    public function setFlgEncerrado($flgEncerrado)
    {
        $this->flgEncerrado = $flgEncerrado;
    }

    /**
     * @return mixed
     */
    public function getDatEncerramento()
    {
        return $this->datEncerramento;
    }

    /**
     * @param mixed $datEncerramento
     */
    public function setDatEncerramento($datEncerramento)
    {
        $this->datEncerramento = $datEncerramento;
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


    public function selecionar($codRomaneio = null, $filtro = null, $auxSQL = null)
    {
        $con = DB::conexao();

        $stringSQL = ' SELECT * FROM romaneio WHERE 1 = 1';

        if ($codRomaneio) {
            $stringSQL .= " AND COD_ROMANEIO = :codRomaneio";
        }

        if (isset($filtro)) {
            $stringSQL .= " AND IFNULL(FLG_ENCERRADO,0) = " . $filtro;
        }

        if (isset($auxSQL)) {
            $stringSQL .= $auxSQL;
        }

        $sql = $con->prepare($stringSQL);

        if ($codRomaneio) {
            $sql->bindParam(":codRomaneio", $codRomaneio);
        }

        //echo $stringSQL . "<br>";

        if ($sql->execute()) {
            $romaneio = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($sql->rowCount() == 1) {

                //$obj = $sql->fetchAll(PDO::FETCH_ASSOC);
                $obj = $romaneio[0];

                $this->setCodRomaneio($obj["COD_ROMANEIO"]);
                $this->setDesRomaneio($obj["DES_ROMANEIO"]);
                $this->setDatRomaneio($obj["DAT_ROMANEIO"]);
                $this->setFlgEncerrado($obj["FLG_ENCERRADO"]);
                $this->setDatEncerramento($obj["DAT_ENCERRAMENTO"]);
                $this->setObs($obj["OBS"]);
            }
            return $romaneio;
        } else {
            return false;
        }

    }

    public function listarTodos($codRomaneio = null)
    {
        $con = DB::conexao();

        $stringSQL = 'SELECT * FROM romaneio';

        //echo $stringSQL . " - " . $pCodPedido . "<br>";
        $sql = $con->prepare($stringSQL);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $obj = $sql->fetchAll(PDO::FETCH_ASSOC);
            $obj = $obj[0];

            $this->setCodRomaneio($obj["COD_ROMANEIO"]);
            $this->setDesRomaneio($obj["DES_ROMANEIO"]);
            $this->setDatRomaneio($obj["DAT_ROMANEIO"]);
            $this->setFlgEncerrado($obj["FLG_ENCERRADO"]);
            return $this;
        } else {
            return false;
        }

    }

    public function salvar()
    {
        $con = DB::conexao();

        if ($this) {
            $stringSQL = "INSERT INTO romaneio (DES_ROMANEIO, DAT_ROMANEIO, FLG_ENCERRADO, DAT_ENCERRAMENTO, OBS) VALUES (";

            //$stringSQL .= "COD_PEDIDO = ";
            $this->getDesRomaneio() ? $stringSQL .= "'" . $this->getDesRomaneio() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getDatRomaneio() ? $stringSQL .= "'" . $this->getDatRomaneio() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getFlgEncerrado() ? $stringSQL .= $this->getFlgEncerrado() : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getDatEncerramento() ? $stringSQL .= $this->getDatEncerramento() : $stringSQL .= 'null';

            $stringSQL .= ", ";
            $this->getObs() ? $stringSQL .= $this->getObs() : $stringSQL .= 'null';

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
        $con = DB::conexao();

        if ($this) {
            $stringSQL = "UPDATE romaneio SET ";

            $stringSQL .= "DES_ROMANEIO = ";
            $this->getDesRomaneio() ? $stringSQL .= "'" . $this->getDesRomaneio() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", DAT_ROMANEIO = ";
            $this->getDatRomaneio() ? $stringSQL .= "'" . $this->getDatRomaneio() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", FLG_ENCERRADO = ";
            $this->getFlgEncerrado() ? $stringSQL .= $this->getFlgEncerrado() : $stringSQL .= 'null';

            $stringSQL .= ", DAT_ENCERRAMENTO = ";
            $this->getDatEncerramento() ? $stringSQL .= "'" . $this->getDatEncerramento() . "'" : $stringSQL .= 'null';

            $stringSQL .= ", OBS = ";
            $this->getObs() ? $stringSQL .= "'" . $this->getObs() . "'" : $stringSQL .= 'null';

            $stringSQL .= " WHERE COD_ROMANEIO = :codRomaneio;";

            //echo $stringSQL . "<br>";
            //exit();
            $sql = $con->prepare($stringSQL);
            $sql->bindParam(":codRomaneio", $this->getCodRomaneio());

            return $sql->execute();
        } else {
            return false;
        }
    }

    public function excluir($codRomaneio)
    {
        $con = DB::conexao();

        if ($codRomaneio) {
            $stringSQL = " DELETE FROM romaneio WHERE COD_ROMANEIO = :codRomaneio ";

            //echo $stringSQL . "<br>";
            //exit();
            $sql = $con->prepare($stringSQL);
            $sql->bindParam(":codRomaneio", $codRomaneio);

            return $sql->execute();
        } else {
            return false;
        }
    }

    public function listaPedidos($codRomaneio, $orderBySQL = null)
    {
        $con = DB::conexao();

        $stringSQL = "SELECT P.COD_PEDIDO, ";
        $stringSQL .= " C.NOM_CLIENTE, ";
        $stringSQL .= " C.DES_CIDADE, ";
        $stringSQL .= " C.DES_BAIRRO, ";
        $stringSQL .= " P.COD_CLIENTE, ";
        $stringSQL .= " P.OBS, ";
        $stringSQL .= " R.COD_ROMANEIO, ";
        $stringSQL .= " R.DES_ROMANEIO, ";
        $stringSQL .= " R.DAT_ROMANEIO, ";
        $stringSQL .= " R.FLG_ENCERRADO, ";
        $stringSQL .= " R.DAT_ENCERRAMENTO, ";
        $stringSQL .= " R.OBS, ";
        $stringSQL .= " COUNT(P.NUM_VOLUME) TOTAL_CONFERIDO, ";
        $stringSQL .= " (SELECT COUNT(PP.NUM_VOLUME) FROM pedido PP WHERE (PP.COD_PEDIDO = P.COD_PEDIDO) AND (PP.COD_ROMANEIO IS NULL OR PP.COD_ROMANEIO = :codRomaneio)) TOTAL_VOLUMES,  ";
        $stringSQL .= " GROUP_CONCAT(P.OBS SEPARATOR ', ') OBS_PEDIDO  ";
        $stringSQL .= " FROM pedido P ";
        $stringSQL .= " LEFT JOIN romaneio R ON (R.COD_ROMANEIO = P.COD_ROMANEIO) ";
        $stringSQL .= " LEFT JOIN cliente C ON (C.COD_CLIENTE = P.COD_CLIENTE) ";
        $stringSQL .= " WHERE P.COD_ROMANEIO = :codRomaneio ";
        $stringSQL .= " GROUP BY P.COD_PEDIDO, COD_CLIENTE ";

        if (!isset($orderBySQL)) {
            $stringSQL .= " ORDER BY C.NOM_CLIENTE ";
        } else {
            $stringSQL .= $orderBySQL;
        }

        $sql = $con->prepare($stringSQL);
        $sql->bindParam(":codRomaneio", $codRomaneio);

        //echo $stringSQL;

        if ($sql->execute()) {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function listaCidadePorRomaneio($codPedido)
    {
		if ($codPedido) {				
			if (is_array($codPedido)){
				$clientes = "";
				foreach ($codPedido as $k => $v){
					$clientes .= $v;
					$clientes .= ($k < (count($codPedido)-1)) ? ", " : "";
				}
			} else {
				$clientes = $codPedido;
			}
							
			require_once "../model/pdo.class.php";
			
			$conOracle = new DB_ORACLE();
			
			$stringSQL  = "SELECT DISTINCT  ";
			$stringSQL .= " CI.TLOC_NOME DES_CIDADE ";
			$stringSQL .= " FROM TCLI_CLIENTE C  ";
			$stringSQL .= " LEFT JOIN TLOC_CIDADE_CEP CI ON (CI.TLOC_CIDADE_CEP_PK = C.TCLI_CIDADE_CEP_FK) ";
			$stringSQL .= " WHERE C.TCLI_CLIENTE_PK in ($clientes) ";
			
			echo $stringSQL;
			
			$cliente = $conOracle->query($stringSQL);	
			return $cliente;				
		} else {
			return false;
		}
    }

    public function ultimo()
    {
        $con = DB::conexao();

        $stringSQL = "SELECT COD_ROMANEIO FROM ROMANEIO ORDER BY DAT_ROMANEIO DESC LIMIT 1";
        $sql = $con->prepare($stringSQL);
        $sql->execute();

        if ($sql->execute()) {
            $romaneio = $sql->fetchAll(PDO::FETCH_ASSOC);
            $romaneio =  $romaneio[0];
            return $romaneio["COD_ROMANEIO"];
        } else {
            return false;
        }
    }
	
	public static function quantidadePedidos($codRomaneio){
		if ($codRomaneio){
			$con = DB::conexao();
			
			$stringSQL = "SELECT COUNT('ID') TOTAL FROM pedido WHERE COD_ROMANEIO = " . $codRomaneio;
			$sql = $con->prepare($stringSQL);
			$sql->execute();
			
			//echo $stringSQL;
			//exit();
			
			if ($sql->execute()) {
				$romaneio = $sql->fetchAll(PDO::FETCH_ASSOC);
				$romaneio =  $romaneio[0];
				return $romaneio["TOTAL"];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
