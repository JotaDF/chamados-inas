<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Setor.php');
require_once('dto/Setor.php');

class ManterSetor extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select s.id,s.sigla,s.descricao, (select count(*) from usuario as u where u.id_setor=s.id) as dep FROM setor as s order by s.sigla";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Setor();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->sigla       = $registro["sigla"];
            $dados->descricao   = $registro["descricao"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getSetorPorId($id) {
        $sql = "select s.id,s.sigla,s.descricao FROM setor as s WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Setor();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->sigla       = $registro["sigla"];
            $dados->descricao   = $registro["descricao"];
        }
        return $dados;
    }
    function salvar(Setor $dados) {
        $dados->setor = $dados->setor;
        $dados->descricao = $dados->descricao;
        $sql = "insert into setor (sigla,descricao) values ('" . $dados->sigla . "','" . $dados->descricao . "')";
        if ($dados->id > 0) {
            $sql = "update setor set sigla='" . $dados->sigla . "',descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from setor where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

