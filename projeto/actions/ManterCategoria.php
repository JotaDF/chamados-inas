<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Categoria.php');
require_once('dto/Categoria.php');

class ManterCategoria extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select c.id,c.nome,c.descricao, (select count(*) from chamado as ch where ch.id_categoria=c.id) as dep FROM categoria as c order by c.nome";
	//echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Categoria();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->descricao   = $registro["descricao"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getCategoriaPorId($id) {
        $sql = "select c.id,c.nome,c.descricao FROM categoria as c WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Categoria();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->descricao   = $registro["descricao"];
        }
        return $dados;
    }
    function salvar(Categoria $dados) {
        $sql = "insert into categoria (nome,descricao) values ('" . $dados->nome . "','" . $dados->descricao . "')";
        if ($dados->id > 0) {
            $sql = "update categoria set nome='" . $dados->nome . "',descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from categoria where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

