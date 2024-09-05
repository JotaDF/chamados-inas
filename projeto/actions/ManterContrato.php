<?php

require_once('Model.php');
require_once('dto/Contrato.php');

class ManterContrato extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select c.id,c.numero, c.ano, c.vigente, c.id_prestador FROM contrato as a order by c.numero";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Contrato();
            $dados->excluir = true;
            $dados->id          = $registro["id"];
            $dados->numero      = $registro["numero"];
            $dados->ano         = $registro["ano"];
            $dados->vigente     = $registro["vigente"];
            $dados->prestador   = $registro["id_prestador"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getContratoPorId($id) {
        $sql = "select c.id,c.numero, c.ano, c.vigente, c.id_prestador FROM contrato as a WHERE c.id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Contrato();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->numero      = $registro["numero"];
            $dados->ano         = $registro["ano"];
            $dados->vigente     = $registro["vigente"];
            $dados->prestador   = $registro["id_prestador"];
        }
        return $dados;
    }
    function salvar(Contrato $dados) {
        $sql = "insert into contrato (numero,ano,vigente,id_prestador) 
                values ('" . $dados->numero . "','" . $dados->ano . "','" . $dados->vigente . "','" . $dados->prestador . "')";
        if ($dados->id > 0) {
            $sql = "update contrato set numero='" . $dados->numero . "',ano='" . $dados->ano . "',vigente='" . $dados->vigente . "',id_prestador='" . $dados->prestador . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from contrato where id=" . $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    public static function delPasta($dir) {
        if(is_dir($dir)){
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delPasta("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        }
        return false;
    }
    public static function addPasta($dir) {
        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
            return true;
        }
        return false;
    }
}

