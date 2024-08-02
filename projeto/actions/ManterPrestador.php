<?php

require_once('Model.php');
require_once('dto/Prestador.php');

class ManterPrestador extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select p.id,p.cnpj,p.razao_social,p.nome_fantasia,p.credenciado,p.telefone,p.ativo,p.id_tipo_prestador, (select count(*) from fiscal_prestador as fp where fp.id_prestador=p.id) as dep FROM prestador as p order by p.razao_social";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Prestador();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id                = $registro["id"];
            $dados->cnpj              = $registro["cnpj"];
            $dados->razao_social      = $registro["razao_social"];
            $dados->nome_fantasia     = $registro["nome_fantasia"];
            $dados->credenciado       = $registro["credenciado"];
            $dados->telefone          = $registro["telefone"];
            $dados->ativo             = $registro["ativo"];
            $dados->tipo_prestador    = $registro["id_tipo_prestador"];

            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getPrestadorPorId($id) {
        $sql = "select p.id,p.cnpj,p.razao_social,p.nome_fantasia,p.credenciado,p.telefone,p.ativo,p.id_tipo_prestador FROM prestador as p WHERE id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Prestador();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->cnpj              = $registro["cnpj"];
            $dados->razao_social      = $registro["razao_social"];
            $dados->nome_fantasia     = $registro["nome_fantasia"];
            $dados->credenciado       = $registro["credenciado"];
            $dados->telefone          = $registro["telefone"];
            $dados->ativo             = $registro["ativo"];
            $dados->tipo_prestador    = $registro["id_tipo_prestador"];
        }
        return $dados;
    }
    function salvar(Prestador $dados) {
        $sql = "insert into prestador (cnpj,razao_social,nome_fantasia,credenciado,telefone,ativo,id_tipo_prestador)
                values ('" . $dados->cnpj . "','" . $dados->razao_social . "','" . $dados->nome_fantasia . "',
                '" . $dados->credenciado . "','" . $dados->telefone . "',1,'" . $dados->tipo_prestador . "')";
        if ($dados->id > 0) {
            $sql = "update prestador set cnpj='" . $dados->cnpj . "', razao_social='" . $dados->razao_social . "',
                    nome_fantasia='" . $dados->nome_fantasia . "', credenciado='" . $dados->credenciado . "',
                    telefone='" . $dados->telefone . "', ativo='" . $dados->ativo . "', id_tipo_prestador='" . $dados->tipo_prestador . "'
                    where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from prestador where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function getExecutoresPorId($id, $id_usuario = 0) {
        $where_user = "";
        if($id_usuario > 0){
            $where_user = " AND u.id=".$id_usuario;
        }
        $sql = "select u.id,u.nome, u.matricula, fp.editor, fp.id as id_fiscal_prestador  FROM usuario as u, fiscal_prestador as fp WHERE u.id=fp.id_usuario AND fp.id_prestador=".$id. $where_user ." order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $dados->matricula = $registro["matricula"];
            $dados->editor = $registro["editor"];
            $dados->id_fiscal_prestador = $registro["id_fiscal_prestador"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function getNaoExecutoresPorId($id) {
        $sql = "select u.id,u.nome FROM usuario as u WHERE u.id NOT IN(SELECT id_usuario FROM fiscal_prestador as fp WHERE fp.id_prestador=".$id.") order by u.nome";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Usuario();
            $dados->excluir = true;
            $dados->id = $registro["id"];
            $dados->nome = $registro["nome"];
            $array_dados[] = $dados;
        }
        return $array_dados;
    }
    function add($id_prestador, $id_usuario, $editor = 0) {
        $sql = "insert into fiscal_prestador (id_prestador,id_usuario, editor) values ('" . $id_prestador . "','" . $id_usuario . "'," . $editor . ")";
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    function del($id_prestador, $id_usuario) {
        $sql = "delete from fiscal_prestador where id_prestador=" . $id_prestador . " AND id_usuario=" . $id_usuario;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function listarPorExecutor($id_executor) {
        $sql = "select p.id,p.cnpj,p.razao_social,p.nome_fantasia,p.credenciado,p.telefone,p.ativo,p.id_tipo_prestador, fp.editor FROM prestador as p, fiscal_prestador fp WHERE p.id=fp.id_prestador AND fp.id_usuario= ".$id_executor." order by p.razao_social";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Prestador();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id                = $registro["id"];
            $dados->cnpj              = $registro["cnpj"];
            $dados->razao_social      = $registro["razao_social"];
            $dados->nome_fantasia     = $registro["nome_fantasia"];
            $dados->credenciado       = $registro["credenciado"];
            $dados->telefone          = $registro["telefone"];
            $dados->ativo             = $registro["ativo"];
            $dados->tipo_prestador    = $registro["id_tipo_prestador"];
            $dados->editor            = $registro["editor"];

            $array_dados[]      = $dados;
        }
        return $array_dados;
    }

}

