<?php

date_default_timezone_set('America/Sao_Paulo');
require_once('Model.php');

require_once('dto/AcessoOficio.php');

class ManterAcessoOficio extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar($filtro = '') {

        $sql = "SELECT a.id, a.id_usuario, a.setor, a.editor, a.ativo, (SELECT COUNT(*) FROM oficio as o WHERE o.id_usuario = a.id_usuario) as dep FROM acesso_oficio as a WHERE 1=1 " . $filtro . " order by a.setor";

        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new AcessoOficio();
            $dados->excluir = true;
            if ($registro["dep"] > 0) {
                $dados->excluir = false;
            }
            $dados->id      = $registro["id"];
            $dados->setor   = $registro["setor"];
            $dados->editor  = $registro["editor"];
            $dados->ativo   = $registro["ativo"];
            $dados->usuario = $registro["id_usuario"];
            $array_dados[]  = $dados;
        }
        return $array_dados;
    }
    

    function getAcessoOficioPorId($id) {
        $sql = "SELECT a.id, a.id_usuario, a.setor, a.editor, a.ativo, (SELECT COUNT(*) FROM oficio as o WHERE o.id_usuario = a.id_usuario) as dep FROM acesso_oficio as a WHERE  id=" . $id;        
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new AcessoOficio();
        while ($registro = $resultado->fetchRow()) {
            $dados->id      = $registro["id"];
            $dados->setor   = $registro["setor"];
            $dados->editor  = $registro["editor"];
            $dados->ativo   = $registro["ativo"];
            $dados->usuario = $registro["id_usuario"];
        }
        return $dados;
    }

    function salvar(AcessoOficio $dados) {
        if($dados->editor == ''){
            $dados->editor = 0;
        }
        if($dados->ativo == ''){
            $dados->ativo = 0;
        }

        $sql = "insert into acesso_oficio (id_usuario, setor, editor, ativo) values (" . $dados->usuario . ",'" . $dados->setor . "','" . $dados->editor . "',1)";
        //echo $sql . "<BR/>";
        if ($dados->id > 0) {
            $sql = "update acesso_oficio set id_usuario=" . $dados->usuario . ",setor='" . $dados->setor . "',editor='" . $dados->editor . "' where id=" . $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        //echo $sql . "<BR/>";
        return $resultado;
    }
    
    function desativar($id) {
        $sql = "update acesso_oficio set ativo=0 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function ativar($id) {
        $sql = "update acesso_oficio set ativo=1 where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from acesso_oficio where id=" . $id; 
        $resultado = $this->db->Execute($sql); // exclui a acesso_oficio
        return $resultado;
    }

}
