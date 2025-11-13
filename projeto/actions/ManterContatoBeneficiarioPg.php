<?php

require_once('ModelPg.php');

class ManterBeneficiarioPg extends ModelPg {

    function __construct($banco = 'df_pessoa_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function getContadoPorCPF($cpf_cnpj) {
        $sql = "SELECT * FROM pessoa WHERE cpf_cnpj  = '$cpf_cnpj'";
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
