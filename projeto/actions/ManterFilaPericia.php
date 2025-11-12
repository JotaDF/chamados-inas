<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('ModelPg.php');

class ManterFilaPericia extends ModelPg {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT * FROM guia WHERE fila_id =18 or id_fila =18";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        // while ($registro = $resultado->fetchRow()) {
        //     $dados = array();
        //     $dados['id'] = $registro["id"];
        //     $array_dados[] = $dados;
        // }
        return $resultado;
    }

}
