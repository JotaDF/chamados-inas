<?php 
require_once('Model.php');
require_once('dto/EapItem.php');
Class ManterEapItem extends Model {

    function __construct() {
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT e.id, e.nome, e.id_projeto, e.id_eap_item, (SELECT COUNT(*) FROM eap_item WHERE id_eap_item = e.id) as dep FROM eap_item as e";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados              = new EapItem;
            $dados->excluir     = true; 
            if($registro["dep"] > 0) {
            $dados->excluir     = false; 
            }
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->projeto     = $registro["id_projeto"];
            $dados->id_eap_item = $registro["id_eap_item"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getEapItemPorId($id) {
     $sql = "SELECT e.id, e.nome, e.id_projeto, e.id_eap_item FROM eap_item as e WHERE id=" . $id;
     $resultado = $this->db->Execute($sql);
     $array_dados = array();
     while($registro = $resultado->fetchRow()) {
        $dados       = new EapItem;
        $dados->id          = $registro["id"];
        $dados->nome        = $registro["nome"];
        $dados->projeto     = $registro["id_projeto"];
        $dados->id_eap_item = $registro["id_eap_item"];
    }
    return $dados;
    }

    function getEapItemPaiPorId($id = 0) {
        $sql = "SELECT e.id, e.nome, e.id_projeto, e.id_eap_item FROM eap_item as e WHERE e.id=" . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados         = new EapItem;
            $dados->nome   = $registro["nome"];
        }
        return $dados;
    }
    
    function getEapItemPorIdProjeto($id = 0) {
        $sql = "SELECT e.id, e.nome, e.id_projeto, e.id_eap_item, ( (SELECT COUNT(*) FROM eap_item WHERE id_eap_item = e.id) + (SELECT COUNT(*) FROM cronograma as c WHERE c.id_eap_item = e.id) ) as dep FROM eap_item as e where e.id_projeto=" . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while($registro = $resultado->fetchRow()) {
            $dados              = new EapItem;
            $dados->excluir     = true;
            if($registro["dep"] > 0) {
            $dados->excluir     = false; 
            }
            $dados->id          = $registro["id"];
            $dados->nome        = $registro["nome"];
            $dados->projeto     = $registro["id_projeto"];
            $dados->id_eap_item = $registro["id_eap_item"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function salvar(EapItem $dados) {
       $sql = "INSERT INTO eap_item (nome, id_projeto, id_eap_item) VALUES ('" . $dados->nome ."', '" . $dados->projeto . "', " . $dados->id_eap_item . ")";
        if($dados->id > 0) {
            $sql = "UPDATE eap_item SET nome= '" . $dados->nome ."', id_projeto= '" . $dados->projeto ."', id_eap_item= " . $dados->id_eap_item ." WHERE id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id = 0) {
        $sql = "DELETE FROM eap_item WHERE id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}