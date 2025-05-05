<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Pergunta.php');
require_once('dto/Pergunta.php');

class ManterPergunta extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select p.id,p.descricao, status, (select count(*) from nota as n where n.id_pergunta=p.id) as dep FROM pergunta as p $filtro order by p.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Pergunta();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->status      = $registro["status"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getPerguntaPorId($id) {
        $sql = "select p.id,p.descricao, status FROM pergunta as p WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Pergunta();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->status      = $registro["status"];
        }
        return $dados;
    }
    function salvar(Pergunta $dados) {
        $sql = "insert into pergunta (descricao) values ('" . $dados->descricao . "')";
        if ($dados->id > 0) {
            $sql = "update pergunta set descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }
    function publicar($id) {
        $sql = "update pergunta set status=1 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function despublicar($id) {
        $sql = "update pergunta set status=0 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from pergunta where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

