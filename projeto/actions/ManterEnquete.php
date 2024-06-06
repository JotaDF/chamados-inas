<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Enquete.php');
require_once('dto/Enquete.php');

class ManterEnquete extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select e.id,e.descricao, status, (select count(*) from nota as n where n.id_enquete=e.id) as dep FROM enquete as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Enquete();
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
    function getEnquetePorId($id) {
        $sql = "select e.id,e.descricao, status FROM enquete as e WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Enquete();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->status      = $registro["status"];
        }
        return $dados;
    }
    function salvar(Enquete $dados) {
        $sql = "insert into enquete (descricao) values ('" . $dados->descricao . "')";
        if ($dados->id > 0) {
            $sql = "update enquete set descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }
    function publicar($id) {
        $sql = "update enquete set status=1 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function despublicar($id) {
        $sql = "update enquete set status=0 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from enquete where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

