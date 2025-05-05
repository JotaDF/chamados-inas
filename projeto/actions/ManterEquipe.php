<?php

require_once('Model.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/samj/dto/Equipe.php');
require_once('dto/Equipe.php');
require_once('dto/Usuario.php');

class ManterEquipe extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = '' ) {
        $sql = "select e.id,e.equipe,e.descricao, criador, (select count(*) from equipe_usuario as eu where eu.id_equipe=e.id) as dep FROM equipe as e $filtro order by e.id";
        $resultado = $this->db->Execute($sql);
        //print_r($resultado);
        //echo $sql;
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Equipe();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id          = $registro["id"];
            $dados->equipe = $registro["equipe"];
            $dados->descricao = $registro["descricao"];
            $dados->criador = $registro["criador"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }

    function getEquipePorId($id) {
        $sql = "select e.id,e.equipe,e.descricao,e.criador FROM equipe as e WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Equipe();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->equipe = $registro["equipe"];
            $dados->descricao = $registro["descricao"];
            $dados->criador = $registro["criador"];
        }
        return $dados;
    }
    function salvar(Equipe $dados) {
        $sql = "insert into equipe (equipe,descricao,criador) values ('" . $dados->equipe . "','" . $dados->descricao . "','" . $dados->criador . "')";
        if ($dados->id > 0) {
            $sql = "update equipe set equipe='" . $dados->equipe . "',descricao='" . $dados->descricao . "',criador='" . $dados->criador . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from equipe where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function getParticimantesPorId($id) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_equipe,u.id_setor,u.id_perfil FROM usuario as u, equipe_usuario as eu WHERE u.id=eu.id_usuario AND eu.id_equipe=".$id." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->login = $registro["login"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
            $dados->whatsapp = $registro["whatsapp"];
            $dados->linkedin = $registro["linkedin"];
            $dados->ativo = $registro["ativo"];
            $dados->equipe = $registro["id_equipe"];
            $dados->setor = $registro["id_setor"];
            $dados->perfil = $registro["id_perfil"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getNaoParticimantesPorId($id) {
        $sql = "select u.id,u.nome,u.login,u.matricula,u.cargo,u.email,u.nascimento, u.whatsapp, u.linkedin,u.ativo,u.id_equipe,u.id_setor,u.id_perfil FROM usuario as u WHERE u.id NOT IN(SELECT id_usuario FROM equipe_usuario as eu WHERE eu.id_equipe=".$id.") order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->login = $registro["login"];
            $dados->matricula = $registro["matricula"];
            $dados->cargo = $registro["cargo"];
            $dados->email = $registro["email"];
            $dados->nascimento = date('Y-m-d', $registro["nascimento"]);
            $dados->whatsapp = $registro["whatsapp"];
            $dados->linkedin = $registro["linkedin"];
            $dados->ativo = $registro["ativo"];
            $dados->equipe = $registro["id_equipe"];
            $dados->setor = $registro["id_setor"];
            $dados->perfil = $registro["id_perfil"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function add($id_equipe, $id_usuario) {
        $sql = "insert into equipe_usuario (id_equipe,id_usuario) values ('" . $id_equipe . "','" . $id_usuario . "')";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function del($id_equipe, $id_usuario) {
        $sql = "delete from equipe_usuario where id_equipe=" . $id_equipe . " AND id_usuario=" . $id_usuario;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

}

