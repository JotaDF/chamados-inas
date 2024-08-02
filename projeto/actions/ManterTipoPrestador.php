<?php

require_once('Model.php');
require_once('dto/TipoPrestador.php');

class ManterTipoPrestador extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select tp.id,tp.tipo, (select count(*) from prestador as p where p.id_tipo_prestador=tp.id) as dep FROM tipo_prestador as tp order by tp.tipo";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new TipoPrestador();
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
    function getTipoPrestadorPorId($id) {
        $sql = "select tp.id,tp.tipo FROM tipo_prestador as tp WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new TipoPrestador();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->tipo       = $registro["tipo"];
        }
        return $dados;
    }
    function salvar(TipoPrestador $dados) {
        $sql = "insert into tipo_prestador (tipo) values ('" . $dados->tipo . "')";
        if ($dados->id > 0) {
            $sql = "update tipo_prestador set tipo_prestador='" . $dados->tipo . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from tipo_prestador where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

