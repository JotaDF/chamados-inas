<?php

require_once('Model.php');
require_once('dto/TipoValor.php');

class ManterTipoValor extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select tv.id,tv.tipo, (select count(*) from valor_processo as vp where vp.id_tipo_valor=tv.id) as dep FROM tipo_valor as tv order by tv.tipo_valor";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new TipoValor();
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
    function getTipoValorPorId($id) {
        $sql = "select tv.id,tv.tipo FROM tipo_valor as tv WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new TipoValor();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->tipo       = $registro["tipo"];
        }
        return $dados;
    }
    function salvar(TipoValor $dados) {
        $sql = "insert into tipo_valor (tipo) values ('" . $dados->tipo . "')";
        if ($dados->id > 0) {
            $sql = "update tipo_valor set tipo_valor='" . $dados->tipo . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from tipo_valor where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

