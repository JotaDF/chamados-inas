<?php

require_once('ModelPg.php');

class ManterFilaPericia extends ModelPg {

    function __construct($banco = 'df_regulacao_consulta_api_live') { //metodo construtor
        parent::__construct($banco);
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
