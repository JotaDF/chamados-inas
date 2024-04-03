<?php

require_once('Model.php');
require_once('dto/ClasseJudicial.php');

class ManterClasseJudicial extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select cj.id,cj.classe_judicial, (select count(*) from processo as p where p.id_classe_judicial=cj.id) as dep FROM classe_judicial as cj order by cj.classe_judicial";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new ClasseJudicial();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->classe_judicial       = $registro["classe_judicial"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getClasseJudicialPorId($id) {
        $sql = "select cj.id,cj.classe_judicial FROM classe_judicial as cj WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new ClasseJudicial();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->classe_judicial       = $registro["classe_judicial"];
        }
        return $dados;
    }
    function salvar(ClasseJudicial $dados) {
        $sql = "insert into classe_judicial (classe_judicial) values ('" . $dados->classe_judicial . "')";
        if ($dados->id > 0) {
            $sql = "update classe_judicial set classe_judicial='" . $dados->classe_judicial . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from classe_judicial where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

