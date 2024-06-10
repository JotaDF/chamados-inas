<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Enquete.php');
require_once('dto/Enquete.php');
require_once('dto/OpcaoEnquete.php');

class ManterEnquete extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select e.id,e.descricao, e.status, (select count(*) from enquete_resposta as n where n.id_enquete=e.id) as dep FROM enquete as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Enquete();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->status      = $registro["status"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getEnquetePorId($id) {
        $sql = "select e.id,e.descricao, e.status FROM enquete as e WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Enquete();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->status      = $registro["status"];
        }
        return $dados;
    }
    function getEnqueteAtiva() {
        $sql = "select e.id,e.descricao,e.status FROM enquete as e WHERE status=1";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Enquete();
        if ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->descricao = $registro["descricao"];
            $dados->status      = $registro["status"];
        } 
        return $dados;
    }
    function salvar(Enquete $dados) {
        $sql = "insert into enquete (descricao) values ('" . $dados->descricao . "')";
        if ($dados->id > 0) {
            $sql = "update enquete set descricao='" . $dados->descricao . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }
    function publicar($id) {
        $sql = "update enquete set status=1 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function despublicar($id) {
        $sql = "update enquete set status=0 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from enquete where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getOpcoesEnquete($id) {
        $sql = "select op.id,op.opcao,op.id_enquete from enquete_opcoes as op where op.id_enquete=$id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new OpcaoEnquete();
            $dados->excluir = true;
            $dados->id          = $registro["id"];
            $dados->opcao       = $registro["opcao"];
            $dados->id_enquete  = $registro["id_enquete"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }

    function addOpcao(OpcaoEnquete $dados) {
        $sql = "insert into enquete_opcoes (opcao,id_enquete) values ('" . $dados->opcao . "','" . $dados->id_enquete . "')";
        
        $resultado = $this->db->Execute($sql);
        $dados->id = $this->db->insert_Id();

        return $resultado;
    }
    function delOpcao($id) {
        $sql = "delete from enquete_opcoes where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function salvarVoto($id_enquete, $id_usuario, $id_opcao) {
        $sql = "insert into enquete_resposta (registro, id_enquete, id_usuario, id_enquete_opcoes) values (CURRENT_TIMESTAMP()," . $id_enquete . "," . $id_usuario . "," . $id_opcao . ")";
        $resultado = $this->db->Execute($sql);
        $dados->id = $this->db->insert_Id();
        return $resultado;
    }

}

