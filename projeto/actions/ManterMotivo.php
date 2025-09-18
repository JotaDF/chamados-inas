<?php

require_once('Model.php');
require_once('dto/Motivo.php');

class ManterMotivo extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro="") {
        $sql = "select a.id,a.motivo, (select count(*) from processo as p where p.id_motivo=a.id) as dep FROM motivo as a $filtro order by a.motivo";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Motivo();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->motivo       = $registro["motivo"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getMotivoPorId($id) {
        $sql = "select a.id,a.motivo FROM motivo as a WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Motivo();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->motivo       = $registro["motivo"];
        }
        return $dados;
    }
    function salvar(Motivo $dados) {
        $sql = "insert into motivo (motivo) values ('" . $dados->motivo . "')";
        if ($dados->id > 0) {
            $sql = "update motivo set motivo='" . $dados->motivo . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $dados;
    }

    function excluir($id) {
        $sql = "delete from motivo where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

