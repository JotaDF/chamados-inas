<?php

require_once('ModelPg.php');

class ManterFilaPericiaPg extends ModelPg {

    function __construct($banco = 'df_regulacao_consulta_api_live') { //metodo construtor
        parent::__construct($banco);
    }

    function listar() {
        $sql = "SELECT g.id, g.autorizacao, g.data_solicitacao, g.id_beneficiario, g.justificativa, g.situacao 
                FROM  guia g
                WHERE g.situacao <> 'CANCELADA'
                AND g.id in (select guia_id from pericia_medica pm where pm.status ='AGUARDANDO_AGENDAMENTO' or pm.status = 'AGENDADA' or pm.status = 'AGUARDANDO_REGULACAO')
                AND (g.fila_id =18 or g.id_fila =18 or g.fila_id =33 or g.id_fila =33)
                ORDER BY g.data_solicitacao";
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
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function listarItensGuia($id_guia) {
        $sql = "SELECT ig.codigo, ig.descricao FROM  item_guia as ig WHERE ig.guia_id= " . $id_guia;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = array();
            $dados['codigo'] = $registro["codigo"];
            $dados['descricao'] = $registro["descricao"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

}
