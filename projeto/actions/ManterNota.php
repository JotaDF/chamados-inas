<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Nota.php');
require_once('dto/Nota.php');

class ManterNota extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro) {
        $sql = "select n.id,n.nota,n.hora_registro, n.id_pergunta FROM nota as n $filtro order by n.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Nota();
            $dados->id          = $registro["id"];
            $dados->nota = $registro["nota"];
            $dados->hora_registro = $registro["hora_registro"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function listarRelatorio($filtro) {
        $sql = "select count(*) as total FROM nota as n " . $filtro;
	//echo $sql;
        $resultado = $this->db->Execute($sql);
        if ($registro = $resultado->fetchRow()) {
            return $registro["total"];
        }
        return 0;
    }
    function getNotaPorId($id) {
        $sql = "select n.id,n.nota,n.hora_registro, n.id_pergunta FROM nota as n WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Nota();
        while ($registro = $resultado->fetchRow()) {
            $dados->id            = $registro["id"];
            $dados->nota          = $registro["nota"];
            $dados->hora_registro = $registro["hora_registro"];
        }
        return $dados;
    }
    function salvar(Nota $dados) {
        $sql = "insert into nota (id_pergunta,nota,hora_registro) values ('" . $dados->pergunta . "','" . $dados->nota . "',now())";
        if ($dados->id > 0) {
            $sql = "update nota set id_pergunta='" . $dados->pergunta . "', nota='" . $dados->nota . "',hora_registro=now() where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from nota where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

