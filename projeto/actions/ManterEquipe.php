<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Equipe.php');
require_once('dto/Equipe.php');

class ManterEquipe extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = '' ) {
        $sql = "select e.id,e.equipe,e.descricao, (select count(*) from usuario as u where u.id_equipe=e.id) as dep FROM equipe as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql);
        //print_r($resultado);
        //echo $sql;
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Equipe();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->equipe = $registro["equipe"];
            $dados->descricao = $registro["descricao"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getEquipePorId($id) {
        $sql = "select e.id,e.equipe,e.descricao FROM equipe as e WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Equipe();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->equipe = $registro["equipe"];
            $dados->descricao = $registro["descricao"];
        }
        return $dados;
    }
    function salvar(Equipe $dados) {
        $dados->equipe = $dados->equipe;
        $dados->descricao = $dados->descricao;
        $sql = "insert into equipe (equipe,descricao) values ('" . $dados->equipe . "','" . $dados->descricao . "')";
        if ($dados->id > 0) {
            $sql = "update equipe set equipe='" . $dados->equipe . "',descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from equipe where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

