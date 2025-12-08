<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');

require_once('dto/Oficio.php');

class ManterOficio extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {

        $sql = "SELECT o.id, o.processo, o.link_sei, o.numero, o.assunto, o.destino, o.origem, o.enviado, o.atendido, o.setor, o.arquivo, o.id_usuario FROM oficio as o WHERE 1=1 ".$filtro." order by o.numero";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Oficio();
            $dados->excluir = true;
            $dados->id          = $registro["id"];
            $dados->processo    = $registro["processo"];
            $dados->link_sei    = $registro["link_sei"];
            $dados->numero      = $registro["numero"];
            $dados->assunto     = $registro["assunto"];
            $dados->destino     = $registro["destino"];
            $dados->origem      = $registro["origem"];
            $dados->enviado     = $registro["enviado"];
            $dados->atendido    = $registro["atendido"];
            $dados->setor       = $registro["setor"];
            $dados->arquivo     = $registro["arquivo"];
            $dados->usuario     = $registro["id_usuario"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getOficioPorId($id) {
        $sql = "SELECT o.id, o.processo, o.link_sei, o.numero, o.assunto, o.destino, o.origem, o.enviado, o.atendido, o.setor, o.arquivo, o.id_usuario FROM oficio as o WHERE id=".$id;
        $resultado = $this->db->Execute($sql);
        $dados = new Oficio();
        while ($registro = $resultado->fetchRow()) {
            $dados->excluir = true;
            $dados->id          = $registro["id"];
            $dados->processo    = $registro["processo"];
            $dados->link_sei    = $registro["link_sei"];
            $dados->numero      = $registro["numero"];
            $dados->assunto     = $registro["assunto"];
            $dados->destino     = $registro["destino"];
            $dados->origem      = $registro["origem"];
            $dados->enviado     = $registro["enviado"];
            $dados->atendido    = $registro["atendido"];
            $dados->setor       = $registro["setor"];
            $dados->arquivo     = $registro["arquivo"];
            $dados->usuario     = $registro["id_usuario"];
        }
        return $dados;
    }

    function salvar(Oficio $dados) {
        $sql = "insert into oficio (processo, link_sei, numero, assunto, destino, origem, enviado, atendido, setor, arquivo, id_usuario) values ('" . $dados->processo . "','" . $dados->link_sei . "','" . $dados->numero . "','" . $dados->assunto . "','" . $dados->destino . "','" . $dados->origem . "','" . $dados->enviado . "',0,'" . $dados->setor . "','" . $dados->arquivo . "','" . $dados->usuario . "')";
        //echo $sql . "<BR/>";
        if ($dados->id > 0) {
            $sql = "update oficio set processo=" . $dados->processo . ",link_sei='" . $dados->link_sei . "',numero='" . $dados->numero . "',assunto='" . $dados->assunto . "',destino='" . $dados->destino . "',origem='" . $dados->origem . "'',origem='" . $dados->origem . "'',enviado='" . $dados->enviado . "'',atendido='" . $dados->atendido . "'',setor='" . $dados->setor . "',arquivo='" . $dados->arquivo . "',id_usuario='" . $dados->usuario . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        //echo $sql . "<BR/>";
        return $resultado;
    }

    function atender($id) {
        $sql = "update oficio set atendido=1 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from oficio where id=" . $id; 
        $resultado = $this->db->Execute($sql); // exclui a oficio
        return $resultado;
    }

}
