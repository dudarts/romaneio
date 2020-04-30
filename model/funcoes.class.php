<?php

class Funcoes
{
    public static function listaValoresArray($vetor){
        $string = "";

        foreach($vetor as $k => $v){
            $string .= $v;
            $string .= ($k == count($vetor)) ? "" : ",";
        }

        return $string;
    }
}