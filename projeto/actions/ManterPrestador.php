<?php

require_once('Model.php');
require_once('dto/Prestador.php');

class ManterPrestador extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select p.id,p.cnpj,p.razao_social,p.nome_fantasia,p.credenciado,p.telefone,p.ativo,p.id_tipo_prestador, (select count(*) from fiscal_prestador as fp where fp.id_prestador=p.id) as dep FROM prestador as p order by p.prestador";
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
            $dados->cnnome_fantasiapj = $registro["nome_fantasia"];
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
            $dados->cnnome_fantasiapj = $registro["nome_fantasia"];
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

}
