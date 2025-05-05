<?php

require_once('Model.php');
require_once('dto/Servico.php');

class ManterServico extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select s.id,s.nome, (select count(*) from fila as f where f.id_servico=s.id) as dep FROM servico as s order by s.nome";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Servico();
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
    function getServicoPorId($id) {
        $sql = "select s.id,s.nome FROM servico as s WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Servico();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->nome       = $registro["nome"];
        }
        return $dados;
    }
    function salvar(Servico $dados) {
        $sql = "insert into servico (nome) values ('" . $dados->nome . "')";
        if ($dados->id > 0) {
            $sql = "update servico set nome='" . $dados->nome . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from servico where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

