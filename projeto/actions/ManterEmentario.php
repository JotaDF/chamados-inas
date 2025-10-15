<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Ementario.php');
require_once('dto/Ementario.php');

class ManterEmentario extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select e.id,e.processo_sei, e.doc_sei, e.nota_juridica, e.ementa, e.atualizado, e.id_usuario FROM ementario as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Ementario();
            $dados->excluir = true;

            $dados->id              = $registro["id"];
            $dados->processo_sei    = $registro["processo_sei"];
            $dados->doc_sei         = $registro["doc_sei"];
            $dados->nota_juridica   = $registro["nota_juridica"];
            $dados->ementa          = $registro["ementa"];
            $dados->atualizado      = $registro["atualizado"];
            $dados->usuario         = $registro["id_usuario"];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }
    function getEmentarioPorId($id) {
        $sql = "select e.id,e.processo_sei, e.doc_sei, e.nota_juridica, e.ementa, e.atualizado, e.id_usuario FROM ementario as e WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Ementario();
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->processo_sei    = $registro["processo_sei"];
            $dados->doc_sei         = $registro["doc_sei"];
            $dados->nota_juridica   = $registro["nota_juridica"];
            $dados->ementa          = $registro["ementa"];
            $dados->atualizado      = $registro["atualizado"];
            $dados->usuario         = $registro["id_usuario"];
        }
        return $dados;
    }

    function salvar(Ementario $dados) {
        $sql = "insert into ementario (processo_sei, doc_sei, nota_juridica, ementa, atualizado, id_usuario) 
                values ('" . $dados->processo_sei . "','" . $dados->doc_sei . "'," . $dados->nota_juridica . ",'" . $dados->ementa . "',now()," . $dados->usuario . ")";
        if ($dados->id > 0) {
            $sql = "update ementario set processo_sei='" . $dados->processo_sei . "',doc_sei='" . $dados->doc_sei . "',nota_juridica='" . $dados->nota_juridica . "',ementa='" . $dados->ementa . "',atualizado=now(), id_usuario=" . $dados->usuario . " where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $dados;
    }

    function excluir($id) {
        $sql = "delete from ementario where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
}

