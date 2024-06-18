<?php

require_once('Model.php');
require_once('dto/ValorProcesso.php');


class ManterValorProcesso extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select vp.id,vp.id_tipo_valor,vp.id_processo, vp.valor, vp.cadastro FROM valor_processo as vp $filtro order by vp.id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new ValorProcesso();
            $dados->excluir = true;

            $dados->id              = $registro["id"];
            $dados->id_tipo_valor   = $registro["id_tipo_valor"];
            $dados->id_processo     = $registro["id_processo"];
            $dados->valor           = $registro["valor"];
            $dados->cadastro        = $registro["cadastro"];
            
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }

    function getValorProcessoPorId($id) {
        $sql = "select vp.id,vp.id_tipo_valor,vp.id_processo, vp.valor, vp.cadastro FROM valor_processo as vp WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new ValorProcesso();
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->id_tipo_valor   = $registro["id_tipo_valor"];
            $dados->id_processo     = $registro["id_processo"];
            $dados->valor           = $registro["valor"];
            $dados->cadastro        = $registro["cadastro"];
        }
        return $dados;
    }
    function salvar(ValorProcesso $dados) {
        $sql = "insert into valor_processo (id_tipo_valor,id_processo,valor,cadastro) 
                values ('" . $dados->id_tipo_valor . "','" . $dados->id_processo . "','" . $dados->valor . "',now())";
        if ($dados->id > 0) {
            $sql = "update valor_processo set id_tipo_valor='" . $dados->id_tipo_valor . "',id_processo='" . $dados->id_processo . "',valor='" . $dados->valor . "',cadastro=now() where id=$dados->id";
            $resultado = $this->db->Execute($sql);
            return $dados;
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
            return $dados;
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from valor_processo where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

