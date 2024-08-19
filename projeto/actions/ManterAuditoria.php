<?php

require_once('Model.php');
require_once('dto/Auditoria.php');


class ManterAuditoria extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select a.id,a.acao,a.objeto, a.informacao, a.data_acao, a.autor FROM auditoria as a $filtro order by a.id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Auditoria();
            $dados->id          = $registro["id"];
            $dados->acao        = $registro["acao"];
            $dados->objeto      = $registro["objeto"];
            $dados->informacao  = $registro["informacao"];
            $dados->data_acao   = $registro["data_acao"];
            $dados->autor       = $registro["autor"];
            
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    
    function getAuditoriaPorId($id) {
        $sql = "select a.id,a.acao,a.objeto, a.informacao, a.data_acao, a.autor FROM auditoria as a WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Auditoria();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->acao        = $registro["acao"];
            $dados->objeto      = $registro["objeto"];
            $dados->informacao  = $registro["informacao"];
            $dados->data_acao   = $registro["data_acao"];
            $dados->autor       = $registro["autor"];
        }
        return $dados;
    }
    function salvar(Auditoria $dados) {
        $sql = "insert into auditoria (acao,objeto,informacao,data_acao,autor) 
                values ('" . $dados->acao . "','" . $dados->objeto . "','" . $dados->informacao . "',now(),'" . $dados->autor . "')";
        if ($dados->id > 0) {
            $sql = "update auditoria set acao='" . $dados->acao . "',objeto='" . $dados->objeto . "',informacao='" . $dados->informacao . "',data_acao=now(),autor='" . $dados->autor . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
            return $dados;
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
            return $dados;
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from auditoria where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

