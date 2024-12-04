<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Evento.php');
require_once('dto/Evento.php');

class ManterEvento extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select e.id,e.descricao, e.titulo, e.inscreve, e.data, e.hora, e.status, (select count(*) from inscricao as n where n.id_evento=e.id) as dep FROM evento as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Evento();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->titulo      = $registro["titulo"];
            $dados->inscreve    = $registro["inscreve"];
            $dados->data        = $registro["data"];
            $dados->hora        = $registro["hora"];
            $dados->status      = $registro["status"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getEventoPorId($id) {
        $sql = "select e.id,e.descricao, e.titulo, e.inscreve, e.data, e.hora, e.status FROM evento as e WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Evento();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->titulo      = $registro["titulo"];
            $dados->inscreve    = $registro["inscreve"];
            $dados->data        = $registro["data"];
            $dados->hora        = $registro["hora"];
            $dados->status      = $registro["status"];
        }
        return $dados;
    }
    function getEventoAtivo() {
        $sql = "select e.id, e.descricao, e.titulo, e.inscreve, e.data, e.hora,e.status FROM evento as e WHERE status=1";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Evento();
        if ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->descricao   = $registro["descricao"];
            $dados->titulo      = $registro["titulo"];
            $dados->inscreve    = $registro["inscreve"];
            $dados->data        = $registro["data"];
            $dados->hora        = $registro["hora"];
            $dados->status      = $registro["status"];
        } 
        return $dados;
    }
    function salvar(Evento $dados) {
        $sql = "insert into evento (titulo, descricao, inscreve, data, hora) 
                values ('" . $dados->titulo . "','" . $dados->descricao . "'," . $dados->inscreve . ",'" . $dados->data . "','" . $dados->hora . "')";
        if ($dados->id > 0) {
            $sql = "update evento set titulo='" . $dados->titulo . "',descricao='" . $dados->descricao . "',inscreve='" . $dados->inscreve . "',data='" . $dados->data . "',hora='" . $dados->hora . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }
    function publicar($id) {
        $sql = "update evento set status=1 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function despublicar($id) {
        $sql = "update evento set status=0 where id=$id";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from evento where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function salvarInscricao($id_evento, $id_usuario) {
        $sql = "insert into inscricao (registro, id_enquete, id_usuario) values (CURRENT_TIMESTAMP()," . $id_enquete . "," . $id_usuario . ")";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function cancelarInscricao($id_evento, $id_usuario) {
        $sql = "delete inscricao where id_enquete=" . $id_enquete . " and id_usuario=" . $id_usuario;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function jaInscreveu($id_evento, $id_usuario) {
        $sql = "select count(*) as total from inscricao where id_evento=$id_evento AND id_usuario=$id_usuario";
        $resultado = $this->db->Execute($sql);
        $total = 0;
        if ($registro = $resultado->fetchRow()) {
            $total   = $registro["total"];
        }
        if($total > 0){
            return true;
        }
        return false;
    }
    function getTotalInscritos($id_evento) {
        $sql = "select count(*) as total from inscricao where id_enquete=$id_enquete";
        $resultado = $this->db->Execute($sql);
        $total = 0;
        if ($registro = $resultado->fetchRow()) { 
            $total = $registro["total"];
        }
        return $total;
    }
}

