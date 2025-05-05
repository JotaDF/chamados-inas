<?php

require_once('Model.php');
require_once('dto/Liminar.php');

class ManterLiminar extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select l.id,l.tipo, (select count(*) from processo as f where f.id_liminar=l.id) as dep FROM liminar as l order by l.tipo";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Liminar();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->tipo       = $registro["tipo"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getLiminarPorId($id) {
        $sql = "select l.id,l.tipo FROM liminar as l WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Liminar();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->tipo       = $registro["tipo"];
        }
        return $dados;
    }
    function salvar(Liminar $dados) {
        $sql = "insert into liminar (tipo) values ('" . $dados->tipo . "')";
        if ($dados->id > 0) {
            $sql = "update liminar set tipo='" . $dados->tipo . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from liminar where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

