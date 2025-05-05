<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Modulo.php');
require_once('dto/Modulo.php');

class ManterModulo extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select m.id,m.nome,m.icone, m.link, (select count(*) from acesso as a where a.id_modulo=m.id) as dep FROM modulo as m order by m.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Modulo();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->icone       = $registro["icone"];
            $dados->link        = $registro["link"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getModuloPorId($id) {
        $sql = "select m.id,m.nome,m.icone FROM modulo as m WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Modulo();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->icone       = $registro["icone"];
            $dados->link        = $registro["link"];
        }
        return $dados;
    }
    function salvar(Modulo $dados) {
        $sql = "insert into modulo (nome,icone,link) values ('" . $dados->nome . "','" . $dados->icone . "','" . $dados->link . "')";
        if ($dados->id > 0) {
            $sql = "update modulo set nome='" . $dados->nome . "',icone='" . $dados->icone . "',link='" . $dados->link . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from modulo where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

