<?php

require_once('ModelPg.php');

class ManterBeneficiarioPg extends ModelPg {

    function __construct($banco = 'df_contrato_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function getBeneficiarioPorId($id_beneficiario) {
        $sql = "SELECT cpf_cnpj, numero_cartao, nome, data_nascimento  FROM segurado WHERE uuid = '$id_beneficiario'";
        $resultado = $this->db->Execute($sql);
            $dados = array();
         if ($registro = $resultado->fetchRow()) {
            $dados['cpf_cnpj'] = $registro["cpf_cnpj"];
            $dados['numero_cartao'] = $registro["numero_cartao"];
            $dados['nome'] = $registro["nome"];
            $dados['data_nascimento'] = $registro["data_nascimento"];
        } 
        return $dados;
    }

}
