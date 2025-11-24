<?php

require_once('Model.php');
require_once('dto/OrgaoOrigem.php');

class ManterOrgaoOrigem extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro="") {
        $sql = "select oo.id,oo.nome, (select count(*) from processo as p where p.id_orgao_origem=oo.id) as dep FROM orgao_origem as oo $filtro order by oo.nome";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new OrgaoOrigem();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->nome       = $registro["nome"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getOrgaoOrigemPorId($id) {
        $sql = "select oo.id,oo.nome FROM orgao_origem as oo WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new OrgaoOrigem();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->nome       = $registro["nome"];
        }
        return $dados;
    }
    function salvar(OrgaoOrigem $dados) {
        $sql = "insert into orgao_origem (nome) values ('" . $dados->nome . "')";
        if ($dados->id > 0) {
            $sql = "update orgao_origem set nome='" . $dados->nome . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $dados;
    }

    function excluir($id) {
        $sql = "delete from orgao_origem where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

