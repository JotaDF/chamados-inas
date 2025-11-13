<?php

require_once('ModelPg.php');

class ManterContatoBeneficiarioPg extends ModelPg {

    function __construct($banco = 'df_pessoa_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function getContadosPorCpf($cpf_cnpj) {
        $sql = "SELECT c.tipo, c.valor FROM contato as c, pessoa as p WHERE c.ativo=true AND p.cpf_cnpj= '$cpf_cnpj' AND c.pessoa_id";
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
