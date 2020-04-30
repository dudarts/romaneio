<?php

/**
 * Created by PhpStorm.
 * User: eduardo
 * Date: 06/05/16
 * Time: 15:35
 */
class Log
{
    private $codLog;
    private $codPedido;
    private $datLog;
    private $desLog;

    /**
     * Log constructor.
     * @param $codPedido
     * @param $desLog
     */
    public function __construct($codPedido, $desLog)
    {
        $this->codPedido = $codPedido;
        $this->desLog = $desLog;

        if ($this->codPedido){
            $this->salvar();
        }
    }

    /**
     * @return mixed
     */
    public function getCodLog()
    {
        return $this->codLog;
    }

    /**
     * @param mixed $codLog
     */
    public function setCodLog($codLog)
    {
        $this->codLog = $codLog;
    }

    /**
     * @return mixed
     */
    public function getCodPedido()
    {
        return $this->codPedido;
    }

    /**
     * @param mixed $codPedido
     */
    public function setCodPedido($codPedido)
    {
        $this->codPedido = $codPedido;
    }

    /**
     * @return mixed
     */
    public function getDatLog()
    {
        return $this->datLog;
    }

    /**
     * @param mixed $datLog
     */
    public function setDatLog($datLog)
    {
        $this->datLog = $datLog;
    }

    /**
     * @return mixed
     */
    public function getDesLog()
    {
        return $this->desLog;
    }

    /**
     * @param mixed $desLog
     */
    public function setDesLog($desLog)
    {
        $this->desLog = $desLog;
    }

   public function salvar(){
       $con = DB::conexao();

       if ($this) {
           $stringSQL = 'INSERT INTO log (COD_PEDIDO, DAT_LOG, DES_LOG) VALUES (';

           $this->getCodPedido() ? $stringSQL .=  $this->getCodPedido() : $stringSQL .= 'null';

           $stringSQL .= ", NOW()";

           $stringSQL .= ", '";
           $this->getDesLog() ? $stringSQL .=  $this->getDesLog() : $stringSQL .= 'null';

           $stringSQL .= "');";


           //echo $stringSQL;
           //exit();
           $sql = $con->prepare($stringSQL);
           return $sql->execute();
       } else {
           return false;
       }
   }
}