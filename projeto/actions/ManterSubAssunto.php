<?php

require_once('Model.php');
require_once('dto/SubAssunto.php');

class ManterSubAssunto extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro="") {
        $sql = "select a.id,a.sub_assunto, (select count(*) from processo as p where p.id_sub_assunto=a.id) as dep FROM sub_assunto as a $filtro order by a.sub_assunto";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new SubAssunto();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->sub_assunto       = $registro["sub_assunto"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getSubAssuntoPorId($id) {
        $sql = "select a.id,a.sub_assunto FROM sub_assunto as a WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new SubAssunto();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->sub_assunto       = $registro["sub_assunto"];
        }
        return $dados;
    }
    function salvar(SubAssunto $dados) {
        $sql = "insert into sub_assunto (sub_assunto) values ('" . $dados->sub_assunto . "')";
        if ($dados->id > 0) {
            $sql = "update sub_assunto set sub_assunto='" . $dados->sub_assunto . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $dados;
    }

    function excluir($id) {
        $sql = "delete from sub_assunto where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

