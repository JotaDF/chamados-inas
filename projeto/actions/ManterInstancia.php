<?php

require_once('Model.php');
require_once('dto/Instancia.php');

class ManterInstancia extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select i.id,i.instancia, (select count(*) from processo as p where p.id_instancia=i.id) as dep FROM instancia as i order by i.instancia";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Instancia();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->instancia       = $registro["instancia"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getInstanciaPorId($id) {
        $sql = "select i.id,i.instancia FROM instancia as i WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Instancia();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->instancia       = $registro["instancia"];
        }
        return $dados;
    }
    function salvar(Instancia $dados) {
        $sql = "insert into instancia (instancia) values ('" . $dados->instancia . "')";
        if ($dados->id > 0) {
            $sql = "update instancia set instancia='" . $dados->instancia . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from instancia where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

