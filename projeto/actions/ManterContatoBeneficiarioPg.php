<?php

require_once('ModelPg.php');

class ManterBeneficiarioPg extends ModelPg {

    function __construct($banco = 'df_pessoa_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function getContadosPorIdPessoa($id_pessoa) {
        $sql = "SELECT id, tipo, valor FROM contato WHERE ativo=true AND pessoa_id  = '$id_pessoa'";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
         while ($registro = $resultado->fetchRow()) {
            $dados = array();
            $dados['tipo'] = $registro["tipo"];
            $dados['valor'] = $registro["valor"];
            $array_dados[] = $dados;
        } 
        return $array_dados;
    }

}
