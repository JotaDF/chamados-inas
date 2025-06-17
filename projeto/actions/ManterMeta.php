<?php 
require_once 'Model.php';
require_once 'dto/Meta.php';

Class ManterMeta extends Model {
    
    function __construct(){
        parent:: __construct();
    }

    function listar() {
        $sql = "SELECT m.id, m.valor, m.data_inicio, m.data_fim, m.id_indicador FROM meta as m";
        $resultado = $this->db->Execute($sql);
        $array_dados = array();
        while ($registro = $resultado->fetchRow()) {
            $dados                = new Meta;
            $dados->id            = $registro['id'];
            $dados->valor         = $registro['valor'];
            $dados->data_inicio   = $registro['data_inicio'];
            $dados->data_fim      = $registro['data_fim'];
            $dados->indicador     = $registro['indicador'];
            $array_dados          = $dados;
        }
        return $array_dados;
    }

    function salvar(Meta $dados) {
        $sql = "INSERT INTO meta(valor, data_inicio, data_fim, id_indicador) VALUES ('". $dados->valor ."','". $dados->data_inicio ."',
        '". $dados->data_fim ."','". $dados->indicador ."')";
        if($dados->id > 0) {
            $sql = "UPDATE meta SET valor='". $dados->valor ."',data_inicio='". $dados->data_inicio ."',
            data_fim='". $dados->data_fim ."',id_indicador='". $dados->indicador ."'";
        $resultado = $this->db->Execute($sql);
        } else {
            $resultado = $this->db->Execute($sql);
            $dados->id = $this->db->insert_Id();
        }
        return $resultado;
    }

    function excluir($id) {
        $sql = "DELETE FROM meta WHERE id=" . $id;
        $resultado = $this->db->Execute($id);
        return $resultado;
    }
}