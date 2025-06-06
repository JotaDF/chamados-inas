<?php

require_once('Model.php');
require_once('dto/Licitacao.php');

class ManterLicitacao extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "select l.id,l.modalidade, l.certame, l.ano FROM licitacao as l order by l.numero";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Licitacao();
            $dados->excluir = true;
            $dados->id          = $registro["id"];
            $dados->modalidade  = $registro["modalidade"];
            $dados->certame     = $registro["certame"];
            $dados->ano         = $registro["ano"];
            $array_dados[]      = $dados;
        }
        return $array_dados;
    }
    function getLicitacaoPorId($id) {
        $sql = "select l.id,l.modalidade, l.certame, l.ano FROM licitacao as l WHERE l.id=$id";
        //echo $sql;
        $resultado = $this->db->Execute($sql);
        $dados = new Licitacao();
        while ($registro = $resultado->fetchRow()) {
            $dados->id          = $registro["id"];
            $dados->modalidade  = $registro["modalidade"];
            $dados->certame     = $registro["certame"];
            $dados->ano         = $registro["ano"];
        }
        return $dados;
    }
    function salvar(Licitacao $dados) {
        $sql = "insert into licitacao (modalidade,certame,ano) 
                values ('" . $dados->modalidade . "','" . $dados->certame . "','" . $dados->ano . "')";
        if ($dados->id > 0) {
            $sql = "update licitacao set modalidade='" . $dados->modalidade . "',certame='" . $dados->certame . "',ano='" . $dados->ano . "' where id=$dados->id";
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "delete from licitacao where id=" . $id;
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

