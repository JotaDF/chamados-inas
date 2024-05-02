<?php

require_once('Model.php');
require_once('dto/Agenda.php');

class ManterAgenda extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = "") {
        $sql = "select a.id, a.titulo, a.descricao, a.cor, a.inicio, a.termino, a.id_usuario, a.id_editor, a.notificado FROM agenda as a $filtro order by a.inicio";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Agenda();
            $dados->excluir = true;
            $dados->id          = $registro["id"];
            $dados->titulo      = $registro["titulo"];
            $dados->descricao   = $registro["descricao"];
            $dados->cor         = $registro["cor"];
            $dados->inicio      = $registro["inicio"];
            $dados->termino     = $registro["termino"];
            $dados->usuario     = $registro["id_usuario"];
            $dados->editor      = $registro["id_editor"];
            $dados->notificado  = $registro["notificado"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getAgendaPorId($id) {
        $sql = "select a.id, a.titulo, a.descricao, a.cor, a.inicio, a.termino, a.id_usuario, a.id_editor, a.notificado FROM agenda as a WHERE a.id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Agenda();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->titulo      = $registro["titulo"];
            $dados->descricao   = $registro["descricao"];
            $dados->cor         = $registro["cor"];
            $dados->inicio      = $registro["inicio"];
            $dados->termino     = $registro["termino"];
            $dados->usuario     = $registro["id_usuario"];
            $dados->editor      = $registro["id_editor"];
            $dados->notificado  = $registro["notificado"];
        }
        return $dados;
    }
    function salvar(Agenda $dados) {
        $sql = "insert into agenda (titulo, descricao, cor, inicio, termino, id_usuario,id_editor) 
                values ('" . $dados->titulo . "','" . $dados->descricao . "','" . $dados->cor . "','" . $dados->inicio . "','" . $dados->termino . "','" . $dados->usuario . "','" . $dados->editor . "')";
        if ($dados->id > 0) {
            $sql = "update agenda set titulo='" . $dados->titulo . "', descricao='" . $dados->descricao . 
                   "', cor='" . $dados->cor . "', inicio='" . $dados->inicio . "', termino='" . $dados->termino . "', id_usuario='" . $dados->usuario . "', id_editor='" . $dados->editor . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }
    function salvarData(Agenda $dados) {
        $sql = "UPDATE agenda SET  inicio = '$dados->inicio', termino = '$dados->termino' WHERE id = " . $dados->id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function salvarNotificacao($id) {
        $sql = "UPDATE agenda SET  notificado = 1 WHERE id = " . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function excluir($id) {
        $sql = "delete from agenda where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function getVisitantesPorId($id) {
        $sql = "select u.id,u.nome,u.matricula,u.ativo,aa.editor, aa.data FROM usuario as u,acesso_agenda as aa WHERE u.ativo=1 AND u.id=aa.id_visitante AND aa.id_usuario=".$id." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->matricula = $registro["matricula"];
            $dados->ativo = $registro["ativo"];
            $dados->editor = $registro["editor"];
            $dados->data = $registro["data"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getNaoVisitantesPorId($id) {
        $sql = "select u.id,u.nome,u.matricula,u.ativo FROM usuario as u WHERE u.ativo=1 AND  u.id NOT IN(SELECT id_visitante FROM acesso_agenda as aa WHERE aa.id_usuario=".$id.") order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->matricula = $registro["matricula"];
            $dados->ativo = $registro["ativo"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getAgendasQueAcesso($id_visitante) {
        $sql = "select aa.id_usuario, u.nome, aa.editor, aa.id_visitante FROM acesso_agenda as aa, usuario as u WHERE u.id= aa.id_usuario AND aa.id_visitante=".$id_visitante;
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new stdClass();
            $dados->id_visitante    = $id_visitante;
            $dados->editor          = $registro["editor"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->nome            = $registro["nome"];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }
    function add($id_visitante,$editor = 0 , $id_usuario) {
        $sql = "insert into acesso_agenda (id_visitante,editor,id_usuario) values ('" . $id_visitante . "'," . $editor . ",'" . $id_usuario . "')";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function del($id_visitante, $id_usuario) {
        $sql = "delete from acesso_agenda where id_visitante=" . $id_visitante . " AND id_usuario=" . $id_usuario;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

