<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Guiche.php');
require_once('dto/Guiche.php');

class ManterGuiche extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select g.id,g.numero,g.id_usuario, (select count(*) from atendimento as a where a.id_guiche=g.id) as dep FROM guiche as g order by g.numero";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Guiche();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->numero      = $registro["numero"];
            $dados->usuario     = $registro["id_usuario"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getGuichePorId($id) {
        $sql = "select g.id,g.numero,g.id_usuario FROM guiche as g WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Guiche();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->numero       = $registro["numero"];
            $dados->usuario   = $registro["id_usuario"];
        }
        return $dados;
    }
    function getGuichePorUsuario($id_usuario) {
        $sql = "select g.id,g.numero,g.id_usuario FROM guiche as g WHERE id_usuario=$id_usuario";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Guiche();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->numero       = $registro["numero"];
            $dados->usuario   = $registro["id_usuario"];
        }
        return $dados;
    }
    function salvar(Guiche $dados) {
        $sql = "insert into guiche (numero,id_usuario) values ('" . $dados->numero . "','" . $dados->usuario . "')";
        if ($dados->id > 0) {
            $sql = "update guiche set numero='" . $dados->numero . "',id_usuario='" . $dados->usuario . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from guiche where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

