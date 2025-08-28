<?php  
require_once('Model.php');
require_once('dto/Reporte.php');

class ManterReporte extends Model {

    function __construct() { //metodo construtor
        parent::__construct();
    }

    function listar() {
        $sql = "SELECT r.id, r.conteudo, r.data, r.tipo, r.id_indicador, r.id_projeto FROM reporte as r";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Reporte();
            $dados->id         = $registro["id"];
            $dados->conteudo   = $registro["conteudo"];
            $dados->data       = $registro["data"];
            $dados->tipo       = $registro["tipo"];
            $dados->indicador  = $registro["id_indicador"];
            $dados->projeto    = $registro["id_projeto"];
            $array_dados[]     = $dados;
        }
        return $array_dados;
    }

    function getReportePorIdProjeto($id = 0) {
        $sql = "SELECT r.id, r.conteudo, r.data, r.tipo, r.id_indicador, r.id_projeto FROM reporte as r WHERE r.id_projeto = " . $id;
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados = new Reporte();
            $dados->id         = $registro["id"];
            $dados->conteudo   = $registro["conteudo"];
            $dados->data       = $registro["data"];
            $dados->tipo       = $registro["tipo"];
            $dados->indicador  = $registro["id_indicador"];
            $dados->projeto    = $registro["id_projeto"];
            $array_dados[]     = $dados;
        }
        return $array_dados;
    }
    // function getIndicadorPorIdObjetivo($id = 0) {
    //     $sql = "SELECT DISTINCT i.id as id_indicador, i.nome FROM indicador as i, objetivo as o, projeto as p, reporte as r WHERE r.id_indicador = i.id AND i.id_objetivo = o.id AND o.id = $id";
    //     $resultado = $this->db->Execute($sql);
    //     $array_dados = array();
    //     while($registro = $resultado->fetchRow()) {
    //         $dados = 
    //     }
    // }
    function salvar(Reporte $dados) {
        $sql = "INSERT INTO reporte (conteudo, tipo, id_indicador, id_projeto) VALUES('" . $dados->conteudo . "', '" . $dados->tipo . "', " . $dados->indicador . ", " . $dados->projeto . ")";
        if($dados->id > 0) {
            $sql = "UPDATE reporte SET conteudo='". $dados->conteudo ."', tipo='". $dados->tipo ."', id_indicador=". $dados->indicador .", id_projeto=". $dados->projeto ." WHERE id=". $dados->id;
            $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir ($id = 0) {
        $sql = "DELETE FROM reporte WHERE id=". $id;
        $resultado = $this->db->Execute($sql);
        return $resultado;
    }
    
}