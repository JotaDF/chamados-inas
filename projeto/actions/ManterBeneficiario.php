<?php

require_once('ModelPg.php');

class ManterBeneficiario extends ModelPg {

    function __construct($banco = 'df_contrato_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function listar($id_beneficiario) {
        $sql = "SELECT * FROM segurado WHERE uuid = '$id_beneficiario'";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
/*         while ($registro = $resultado->fetchRow()) {
            $dados = array();
            $dados['id'] = $registro["id"];
            $dados['autorizacao'] = $registro["autorizacao"];
            $dados['data_solicitacao'] = $registro["data_solicitacao"];
            $dados['id_beneficiario'] = $registro["id_beneficiario"];
            $dados['justificativa'] = $registro["justificativa"];
            $dados['situacao'] = $registro["situacao"];
            $array_dados[] = $dados;
        } */
        return $resultado;
    }

}
