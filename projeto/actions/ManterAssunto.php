<?php

require_once('Model.php');
require_once('dto/Assunto.php');

class ManterAssunto extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro="") {
        $sql = "select a.id,a.assunto, (select count(*) from processo as p where p.id_assunto=a.id) as dep FROM assunto as a $filtro order by a.assunto";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Assunto();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->assunto       = $registro["assunto"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getAssuntoPorId($id) {
        $sql = "select a.id,a.assunto FROM assunto as a WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Assunto();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->assunto       = $registro["assunto"];
        }
        return $dados;
    }
    function salvar(Assunto $dados) {
        $sql = "insert into assunto (assunto) values ('" . $dados->assunto . "')";
        if ($dados->id > 0) {
            $sql = "update assunto set assunto='" . $dados->assunto . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from assunto where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

