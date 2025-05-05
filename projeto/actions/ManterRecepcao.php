<?php

require_once('Model.php');
require_once('dto/Recepcao.php');

class ManterRecepcao extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select r.id, r.visitante, r.empresa, r.horario, r.setor, r.recebido_por, r.assunto, r.id_usuario, r.cadastro FROM recepcao as r order by r.id DESC";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Recepcao();
            $dados->excluir         = true;
            $dados->id              = $registro["id"];
            $dados->visitante       = $registro["visitante"];
            $dados->empresa         = $registro["empresa"];
            $dados->horario         = $registro["horario"];
            $dados->setor           = $registro["setor"];
            $dados->recebido_por    = $registro["recebido_por"];
            $dados->assunto         = $registro["assunto"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->cadastro        = $registro["cadastro"];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }
    function listarRelatorio($filtro = "") {
        $sql = "select r.id, r.visitante, r.empresa, r.horario, r.setor, r.recebido_por, r.assunto, r.id_usuario, r.cadastro, u.nome FROM recepcao as r, usuario as u WHERE u.id=r.id_usuario $filtro order by r.cadastro";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Recepcao();
            $dados->excluir         = true;
            $dados->id              = $registro["id"];
            $dados->visitante       = $registro["visitante"];
            $dados->empresa         = $registro["empresa"];
            $dados->horario         = $registro["horario"];
            $dados->setor           = $registro["setor"];
            $dados->recebido_por    = $registro["recebido_por"];
            $dados->assunto         = $registro["assunto"];
            $dados->usuario         = $registro["nome"];
            $dados->cadastro        = $registro["cadastro"];
            $array_dados[]          = $dados;
        }
        return $array_dados;
    }
    function getRecepcaoPorId($id) {
        $sql = "select r.id, r.visitante, r.empresa, r.horario, r.setor, r.recebido_por, r.assunto, r.id_usuario, r.cadastro FROM recepcao as r WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Recepcao();
        while ($registro = $resultado->fetchRow()) {
            $dados->id              = $registro["id"];
            $dados->visitante       = $registro["visitante"];
            $dados->empresa         = $registro["empresa"];
            $dados->horario         = $registro["horario"];
            $dados->setor           = $registro["setor"];
            $dados->recebido_por    = $registro["recebido_por"];
            $dados->assunto         = $registro["assunto"];
            $dados->usuario         = $registro["id_usuario"];
            $dados->cadastro        = $registro["cadastro"];
        }
        return $dados;
    }
    function salvar(Recepcao $dados) {
        $sql = "insert into recepcao (visitante, empresa, horario, setor, recebido_por, assunto, id_usuario, cadastro)
                values ('" .$dados->visitante . "','" .$dados->empresa . "','" .$dados->horario . "','" .$dados->setor . "','" .$dados->recebido_por . "','" .$dados->assunto . "','" .$dados->usuario . "',now())";
        if ($dados->id > 0) {
            $sql = "update recepcao set visitante='" . $dados->visitante . "', empresa='" . $dados->empresa . "',
            horario='" . $dados->horario . "', setor='" . $dados->setor . "', recebido_por='" . $dados->recebido_por . "',
            assunto='" . $dados->assunto . "', id_usuario='" . $dados->usuario . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from recepcao where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

