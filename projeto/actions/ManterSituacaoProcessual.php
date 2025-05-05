<?php

require_once('Model.php');
require_once('dto/SituacaoProcessual.php');

class ManterSituacaoProcessual extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select sp.id,sp.situacao, (select count(*) from processo as p where p.id_situacao_processual=sp.id) as dep FROM situacao_processual as sp order by sp.situacao";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new SituacaoProcessual();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->situacao       = $registro["situacao"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getSituacaoProcessualPorId($id) {
        $sql = "select sp.id,sp.situacao FROM situacao_processual as sp WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new SituacaoProcessual();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->situacao       = $registro["situacao"];
        }
        return $dados;
    }
    function salvar(SituacaoProcessual $dados) {
        $sql = "insert into situacao_processual (situacao) values ('" . $dados->situacao . "')";
        if ($dados->id > 0) {
            $sql = "update situacao_processual set situacao='" . $dados->situacao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from situacao_processual where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

