<?php

require_once('ModelPg.php');

class ManterBeneficiarioPg extends ModelPg {

    function __construct($banco = 'df_contrato_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function getBeneficiarioPorId($id_beneficiario) {
        $sql = "SELECT * FROM segurado WHERE uuid = '$id_beneficiario'";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
         while ($registro = $resultado->fetchRow()) {
            $dados = array();
            $dados['cpf_cnpj'] = $registro["cpf_cnpj"];
            $dados['nome'] = $registro["nome"];
            $dados['data_nascimento'] = $registro["data_nascimento"];
            $array_dados[] = $dados;
        } 
        return $array_dados;
    }

}
