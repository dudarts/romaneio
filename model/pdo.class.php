<?php
 
    /**
     * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
     * Modo de Usar:
     * require_once './Database.class.php';
     * $db = Database::conexao();
     * E agora use as funções do PDO (prepare, query, exec) em cima da variável $db.
     */
    class DB
    {
        
        # Variável que guarda a conexão PDO.
        protected static $db;
        
        # Private construct - garante que a classe só possa ser instanciada internamente.
        private function __construct()
        {
            # Informações sobre o banco de dados:
           
            
            $db_host = "localhost";
            $db_nome = "romaneio";
            

            $db_usuario = "";
            $db_senha = "";
            
            $db_driver = "mysql";
            # Informações sobre o sistema:
            $sistema_email = "dudarts@msn.com";
            $sistema_titulo = "Sistema de Romaneio - INTRANET";
            
            try {
                # Atribui o objeto PDO à variável $db.
                self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome; port=33060", $db_usuario, $db_senha);
                # Garante que o PDO lance exceções durante erros.
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                # Garante que os dados sejam armazenados com codificação UFT-8.
                self::$db->exec('SET NAMES utf8');
            } catch (PDOException $e) {
                # Envia um e-mail para o e-mail oficial do sistema, em caso de erro de conexão.
                mail($sistema_email, "PDOException em $sistema_titulo", $e->getMessage());
                # Então não carrega nada mais da página.
                die("Connection Error: " . $e->getMessage());
            }
        }
        
        # Método estático - acessível sem instanciação.
        public static function conexao()
        {
            # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
            if (!self::$db) {
                new DB();
            }
            # Retorna a conexão.
            return self::$db;
        }
        
    }
    
    
    class DB_ORACLE
    {
        
        public $conn;
        
        public function conectar()
        {
            
            $oracleString = '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.0.100)(PORT=1521)))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=XE)))';
            $oracleUsuario = '';
            $oracleSenha = '';
            
            
            $this->conn = oci_connect($oracleUsuario, $oracleSenha, $oracleString, 'UTF8');
            //$this->conn->debug = true;
            //$this->conn->NLS_DATE_FORMAT = 'YYYY/MM/DD';
            
            if (!$this->conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            
            
            $s = oci_parse($this->conn, "ALTER SESSION SET NLS_DATE_FORMAT='YYYY-MM-DD HH24:MI:SS'");
            oci_execute($s);
            
            $s = oci_parse($this->conn, "ALTER SESSION SET NLS_NUMERIC_CHARACTERS = '.,'");
            oci_execute($s);
            
            //$this->conectar();
            //$sql = "ALTER SESSION SET NLS_DATE_FORMAT='YYYY/MM/DD'";
            
            //$this->conn->execQuery("select * from vedi_vendedor");
            //        $this->desconectar();
        }
        
        public function desconectar()
        {
            oci_close($this->conn);
        }
        
        
        private function execQuery($stid, $type = 0, $openClose = true)
        {
            $r = oci_execute($stid);
            
            //Log::addLog("Consulta Executada");
            
            if (!$r) {
                $e = oci_error($stid);  // For oci_execute errors pass the statement handle
                //Log::addLog("Erro:" . $e['message']);
                print htmlentities($e['message']);
                print "\n<pre>\n";
                print htmlentities($e['sqltext']);
                printf("\n%" . ($e['offset'] + 1) . "s", "^");
                print  "\n</pre>\n";
            }
            $listaDeResultados = [];
            
            //Log::addLog("Criando lista de informações");
            if ($type == 0) {
                $i = 0;
                while ($row = oci_fetch_object($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    $listaDeResultados[$i] = $row;
                    $i++;
                }
            } else if ($type == 1) {
                $i = 0;
                while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    $listaDeResultados[$i] = $row;
                    $i++;
                }
            }
            //Log::addLog("Informações carregadas");
            if ($openClose)
                $this->desconectar();
            
            return $listaDeResultados;
        }
        
        public function queryWithParameters($sql, $parameters, $type = 0, $openClose = true)
        {
            
            //Log::addLog("Executando consulta '$sql' com parametros: " . json_encode($parameters));
            
            if ($openClose)
                $this->conectar();
            
            $stid = oci_parse($this->conn, $sql);
            if (!$stid) {
                $e = oci_error($this->conn);  // For oci_parse errors pass the connection handle
                
                //  Log::addLog("Erro: " . $e['message']);
                
                trigger_error(htmlentities($e['message']), E_USER_ERROR);
            }
            
            foreach ($parameters as $key => $valor) {
                oci_bind_by_name($stid, $key, $parameters[$key]);
            }
            
            $return = $this->execQuery($stid, $type, $openClose);
            
            return $return;
        }
        
        public function query($sql, $openClose = true)
        {
            if ($openClose)
                $this->conectar();
            
            $stid = oci_parse($this->conn, $sql);
            if (!$stid) {
                $e = oci_error($this->conn);  // For oci_parse errors pass the connection handle
                trigger_error(htmlentities($e['message']), E_USER_ERROR);
            }
            return $this->execQuery($stid, $openClose);
        }
        
    }
    
    ?>