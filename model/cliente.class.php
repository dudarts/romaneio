<?php
    @session_start();
    
    require_once "pdo.class.php";
    
    class Cliente
    {
        private $codCliente;
        private $nomCliente;
        private $desCidade;
        private $desBairro;
        private $ptoReferencia;
        
        
        public function setCodCliente($pCodCliente)
        {
            $this->codCliente = $pCodCliente;
        }
        
        public function getCodCliente()
        {
            return $this->codCliente;
        }
        
        public function setNomCliente($pNomCliente)
        {
            $this->nomCliente = $pNomCliente;
        }
        
        public function getNomCliente()
        {
            return $this->nomCliente;
        }
        
        public function setDesCidade($pDesCidade)
        {
            $this->desCidade = $pDesCidade;
        }
        
        public function getDesCidade()
        {
            return $this->desCidade;
        }
        
        public function setDesBairro($pDesBairro)
        {
            $this->desBairro = $pDesBairro;
        }
        
        public function getDesBairro()
        {
            return $this->desBairro;
        }
        
        public function setPtoReferencia($ptoReferencia)
        {
            $this->ptoReferencia = $ptoReferencia;
        }
        
        public function getPtoReferencia()
        {
            return $this->ptoReferencia;
        }
        
        public function selecionar($codCliente = false, $filtro = null)
        {
            $con = DB::conexao();
            
            $stringSQL = " SELECT * FROM cliente WHERE 1 = 1 ";
            
            if ($codCliente) {
                $stringSQL .= " AND COD_CLIENTE = :codCliente";
            }
            
            if ($filtro) {
                $stringSQL .= " AND NOM_CLIENTE LIKE '" . $filtro . "%'";
            }
            
            // $stringSQL .= " limit 50";
            $sql = $con->prepare($stringSQL);
            $sql->bindParam(":codCliente", $codCliente);
            
            
            //echo Funcoes::queryStringSQL($stringSQL, ":codOtica", $pCodOtica, ":usuario", $pCodUsuario, ":senha", $pCodSenha);
            
            if ($sql->execute()) {
                $cliente = $sql->fetchAll(PDO::FETCH_ASSOC);
                if ($sql->rowCount() == 1) {
                    $obj = $cliente[0];
                    
                    $this->setCodCliente($obj["COD_CLIENTE"]);
                    $this->setDesCidade($obj["DES_CIDADE"]);
                    $this->setDesBairro($obj["DES_BAIRRO"]);
                    $this->setPtoReferencia($obj["FLG_ENTREGADOR"]);
                    $this->setNomCliente($obj["NOM_CLIENTE"]);
                }
                return $cliente;
                
            } else {
                return false;
            }
        }
        
        public function salvar()
        {
            $con = DB::conexao();
            
            if ($this) {
                $stringSQL = "INSERT INTO cliente (COD_CLIENTE, NOM_CLIENTE, DES_CIDADE, DES_BAIRRO) VALUES (";
                
                //$stringSQL .= "COD_PEDIDO = ";
                $this->getCodCliente() ? $stringSQL .= "'" . $this->getCodCliente() . "'" : $stringSQL .= 'null';
                
                $stringSQL .= ", ";
                $this->getNomCliente() ? $stringSQL .= "'" . $this->getNomCliente() . "'" : $stringSQL .= 'null';
                
                $stringSQL .= ", ";
                $this->getDesCidade() ? $stringSQL .= "'" . $this->getDesCidade() . "'" : $stringSQL .= 'null';
                
                $stringSQL .= ", ";
                $this->getDesBairro() ? $stringSQL .= "'" . $this->getDesBairro() . "'" : $stringSQL .= 'null';
                
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
                $stringSQL = "UPDATE cliente SET ";
                
                $stringSQL .= "COD_CLIENTE = ";
                $this->getCodCliente() ? $stringSQL .= "'" . $this->getCodCliente() . "'" : $stringSQL .= 'null';
                
                $stringSQL .= ", NOM_CLIENTE = ";
                $this->getNomCliente() ? $stringSQL .= "'" . $this->getNomCliente() . "'" : $stringSQL .= 'null';
                
                $stringSQL .= ", DES_CIDADE = ";
                $this->getDesCidade() ? $stringSQL .= "'" . $this->getDesCidade() . "'" : $stringSQL .= 'null';
                
                $stringSQL .= ", DES_BAIRRO = ";
                $this->getDesBairro() ? $stringSQL .= "'" . $this->getDesBairro() . "'" : $stringSQL .= 'null';
                
                $stringSQL .= " WHERE COD_CLIENTE = :codCliente;";
                
                // echo $stringSQL . $this->getCodCliente() ." <br>";
                //exit();
                $sql = $con->prepare($stringSQL);
                $sql->bindParam(":codCliente", $this->getCodCliente());
                
                return $sql->execute();
            } else {
                return false;
            }
        }
        
        public function letrasIniciais()
        {
            $con = DB::conexao();
            $stringSQL = " SELECT DISTINCT  LEFT(NOM_CLIENTE, 1) LETRA FROM romaneio.cliente ORDER BY LETRA ";
            $sql = $con->prepare($stringSQL);
            
            if ($sql->execute()) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        }
        
        
        public function selecionarPeloPedido($codPedido){
            if ($codPedido) {				
				if (is_array($codPedido)){
					$pedidos = "";
					foreach ($codPedido as $k => $v){
						$pedidos .= $v;
						$pedidos .= ($k < (count($codPedido)-1)) ? ", " : "";
					}
				} else {
					$pedidos = $codPedido;
				}
								
				require_once "../model/pdo.class.php";
                
                $conOracle = new DB_ORACLE();
				
				$stringSQL = "SELECT DISTINCT T.* FROM (";				
                $stringSQL .= "SELECT P.TPED_NUMERO_PEDIDO_PK COD_PEDIDO, ";
                $stringSQL .= " C.TCLI_CLIENTE_PK COD_CLIENTE, ";
                $stringSQL .= " C.TCLI_NOME_RAZAO NOM_CLIENTE, ";
                $stringSQL .= " C.TCLI_BAIRRO DES_BAIRRO, ";
                $stringSQL .= " C.TCLI_PONTO_REFERENCIA DES_PONTO_REFERENCIA, ";
                $stringSQL .= " CI.TLOC_NOME DES_CIDADE, ";
                $stringSQL .= " CI.TLOC_UF_FK COD_ESTADO ";
                $stringSQL .= " FROM TPED_HISTORICO_VENDA P ";
                $stringSQL .= " INNER JOIN TCLI_CLIENTE C ON (C.TCLI_CLIENTE_PK = P.TPED_CLIENTE_FK) ";
                $stringSQL .= " LEFT JOIN TLOC_CIDADE_CEP CI ON (CI.TLOC_CIDADE_CEP_PK = C.TCLI_CIDADE_CEP_FK) ";
                $stringSQL .= " WHERE P.TPED_NUMERO_PEDIDO_PK in ($pedidos) ";
				$stringSQL .= " UNION ALL ";
				$stringSQL .= "SELECT P.TPED_NUMERO_PEDIDO_PK COD_PEDIDO, ";
				$stringSQL .= " C.TCLI_CLIENTE_PK COD_CLIENTE, ";
				$stringSQL .= " C.TCLI_NOME_RAZAO NOM_CLIENTE, ";
				$stringSQL .= " C.TCLI_BAIRRO DES_BAIRRO, ";
				$stringSQL .= " C.TCLI_PONTO_REFERENCIA DES_PONTO_REFERENCIA, ";
				$stringSQL .= " CI.TLOC_NOME DES_CIDADE, ";
				$stringSQL .= " CI.TLOC_UF_FK COD_ESTADO ";
				$stringSQL .= " FROM TPED_PEDIDO_VENDA P ";
				$stringSQL .= " INNER JOIN TCLI_CLIENTE C ON (C.TCLI_CLIENTE_PK = P.TPED_CLIENTE_FK) ";
				$stringSQL .= " LEFT JOIN TLOC_CIDADE_CEP CI ON (CI.TLOC_CIDADE_CEP_PK = C.TCLI_CIDADE_CEP_FK) ";
				$stringSQL .= " WHERE P.TPED_NUMERO_PEDIDO_PK in ($pedidos)) T ORDER BY T.NOM_CLIENTE ";
                //echo $stringSQL;
                
                $cliente = $conOracle->query($stringSQL);
				//var_dump($cliente);
                if (count($cliente) > 0) {
                    
                    $this->setCodCliente($cliente[0]["COD_CLIENTE"]);
                    $this->setNomCliente($cliente[0]["NOM_CLIENTE"]);
                    $this->setDesCidade($cliente[0]["DES_CIDADE"]);
                    $this->setDesBairro($cliente[0]["DES_BAIRRO"]);
                    $this->setPtoReferencia($cliente[0]["DES_PONTO_REFERENCIA"]);
                    
                    return $cliente;
                } else {		
						return false;
					}
				
            } else {
                return false;
            }
            
        }
		
		public function selecionarProton($codPedido){
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
				
                $stringSQL  = "SELECT  ";
                $stringSQL .= " C.TCLI_CLIENTE_PK COD_CLIENTE, ";
                $stringSQL .= " C.TCLI_NOME_RAZAO NOM_CLIENTE, ";
                $stringSQL .= " C.TCLI_BAIRRO DES_BAIRRO, ";
                $stringSQL .= " C.TCLI_PONTO_REFERENCIA DES_PONTO_REFERENCIA, ";
                $stringSQL .= " CI.TLOC_NOME DES_CIDADE, ";
                $stringSQL .= " CI.TLOC_UF_FK COD_ESTADO ";
                $stringSQL .= " FROM TCLI_CLIENTE C  ";
                $stringSQL .= " LEFT JOIN TLOC_CIDADE_CEP CI ON (CI.TLOC_CIDADE_CEP_PK = C.TCLI_CIDADE_CEP_FK) ";
                $stringSQL .= " WHERE C.TCLI_CLIENTE_PK in ($clientes) ";
				
                //echo $stringSQL;
                
                $cliente = $conOracle->query($stringSQL);
				//var_dump($cliente);
                if (count($cliente) == 1) {                   
                    $this->setCodCliente($cliente[0]["COD_CLIENTE"]);
                    $this->setNomCliente($cliente[0]["NOM_CLIENTE"]);
                    $this->setDesCidade($cliente[0]["DES_CIDADE"]);
                    $this->setDesBairro($cliente[0]["DES_BAIRRO"]);
                    $this->setPtoReferencia($cliente[0]["DES_PONTO_REFERENCIA"]);                  
                } 
				return $cliente;				
            } else {
                return false;
            }
            
        }
        
    }
