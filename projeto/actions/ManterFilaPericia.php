<?php

require_once('ModelPg.php');

class ManterFilaPericia extends ModelPg {

    function __construct($banco = 'df_regulacao_consulta_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function listar() {
        $sql = "SELECT g.id, g.autorizacao, g.data_solicitacao, g.id_beneficiario, g.justificativa, g.situacao, i.codigo, i.descricao
        FROM guia as g, item_guia as i 
        WHERE i.guia_id=g.id AND (fila_id =18 or id_fila =18)";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = array();
            $dados['id'] = $registro["id"];
            $dados['autorizacao'] = $registro["autorizacao"];
            $dados['data_solicitacao'] = $registro["data_solicitacao"];
            $dados['id_beneficiario'] = $registro["id_beneficiario"];
            $dados['justificativa'] = $registro["justificativa"];
            $dados['situacao'] = $registro["situacao"];
            $dados['codigo'] = $registro["codigo"];
            $dados['descricao'] = $registro["descricao"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

}
